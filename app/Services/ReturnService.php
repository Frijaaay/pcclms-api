<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use App\Contracts\Services\ReturnServiceInterface;
use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Exceptions\InvalidRequestException;
use Carbon\Carbon;

class ReturnService implements ReturnServiceInterface
{
    /** Dependency Injection */
    private ReturnRepositoryInterface $returnRepository;
    private BorrowRepositoryInterface $borrowRepository;
    private SettingRepositoryInterface $settingRepository;
    private BookRepositoryInterface $bookRepository;
    public function __construct(
        ReturnRepositoryInterface $returnRepository,
        BorrowRepositoryInterface $borrowRepository,
        SettingRepositoryInterface $settingRepository,
        BookRepositoryInterface $bookRepository
        )
    {
        $this->returnRepository = $returnRepository;
        $this->borrowRepository = $borrowRepository;
        $this->settingRepository = $settingRepository;
        $this->bookRepository = $bookRepository;
    }

    /** Handles book returning */
    public function returnBook(array $data)
    {
        /** Checks the borrow record */
        $borrowed_book = $this->borrowRepository->getById($data['borrow_id']);
        if(!$borrowed_book) {
            throw new InvalidRequestException("Transaction doesn't exist", 404);
        }

        /** Setting the dates */
        $due_date = $borrowed_book->due_at;
        $return_date = now();

        /** Calculating Penalties */
        $late_penalty = $this->calculateLatePenalty($due_date, $return_date);
        $condition_penalty = $this->calculateConditionPenalty($data['condition'], $borrowed_book->book_copy_id);
        $total_penalty = $late_penalty + $condition_penalty;

        /** Creates the return record data */
        $returned_data = [
            'borrowed_book_id' => $borrowed_book->id,
            'librarian_id' => auth()->user()->id,
            'returned_condition' => $data['condition'],
            'penalty' => $total_penalty
        ];

        /** Sets Book status and condition */
        $this->bookRepository->updateBookCopyStatus($borrowed_book->book_copy_id, $data['condition']);

        $returned_book = $this->returnRepository->store($returned_data);

        return [
            'message' => 'Book successfully returned',
            'data' => $returned_book
        ];
    }

    private function calculateLatePenalty(Carbon $due_date, Carbon $return_date)
    {
        $penalty = $this->settingRepository->getRule('lates_penalty');
        $total_late_penalty = 0;

        if ($return_date->greaterThan($due_date)) {
            $days_late = (int) $due_date->diffInDays($return_date);
            $total_late_penalty = $days_late * $penalty;
        }

        return $total_late_penalty;
    }

    private function calculateConditionPenalty(string $condition, int $book_copy_id)
    {
        $book_copy = $this->bookRepository->findBookCopy($book_copy_id);

        if ($book_copy->condition == $condition) {
            return 0;
        }
            return match ($condition) {
                'Good' => 0,
                'Slightly Damaged' => $this->settingRepository->getRule('damaged_penalty') / 2,
                'Severely Damaged' => $this->settingRepository->getRule('damaged_penalty'),
                'Lost' => $this->settingRepository->getRule('lost_penalty'),
                default => 0
        };
    }

}

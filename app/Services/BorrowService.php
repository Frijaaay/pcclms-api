<?php

namespace App\Services;

use App\Contracts\Services\BorrowServiceInterface;
use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use App\Exceptions\InvalidRequestException;
use Carbon\Carbon;

class BorrowService implements BorrowServiceInterface
{
    /** Dependecy Injection */
    // private BorrowRepositoryInterface $borrowRepository;
    // private SettingRepositoryInterface $settingRepository;
    // private BookRepositoryInterface $bookRepository;
    public function __construct(
        private BorrowRepositoryInterface $borrowRepository,
        private BookRepositoryInterface $bookRepository,
        private SettingRepositoryInterface $settingRepository
        ) {}

    /** Handles borrowing of book */
    public function borrowBook(array $data)
    {
        $max_borrows = $this->settingRepository->getRule('max_borrowable');
        if ($this->getBorrowCount($data['borrower_id']) >= $max_borrows) {
            throw new InvalidRequestException("Borrow limit reached. You can only borrow {$max_borrows} books at a time.", 403);
        }

        if(!$this->bookRepository->isBookAvailable($data['book_copy_id'])) {
            throw new InvalidRequestException('Book is Unavailable', 404);
        }

        /** This set the copy status into borrowed */
        $this->bookRepository->updateBookCopyStatus($data['book_copy_id'], null);

        $librarian_id = auth()->user()->id;
        $borrowed_at = Carbon::now();
        $due_at = $borrowed_at->copy()->addDays(7);

        $data = [
            'borrower_id' => $data['borrower_id'],
            'book_copy_id' => $data['book_copy_id'],
            'librarian_id' => $librarian_id,
            'borrowed_at' => $borrowed_at,
            'due_at' => $due_at
        ];

        $borrowed_book = $this->borrowRepository->store($data);

        return [
            'message' => 'Book is borrowed by ' . $data['borrower_id'],
            'data' => $borrowed_book
        ];
    }

    private function getBorrowCount(string $id)
    {

        return $this->borrowRepository->getBorrowed($id);
    }
}

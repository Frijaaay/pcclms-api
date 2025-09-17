<?php

namespace App\Services;

use App\Contracts\Services\BorrowServiceInterface;
use App\Exceptions\InvalidRequestException;
use App\Repositories\BorrowRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class BorrowService implements BorrowServiceInterface
{
    /** Dependecy Injection */
    private BorrowRepository $borrowRepository;
    private SettingRepository $settingRepository;
    public function __construct(
        BorrowRepository $borrowRepository,
        SettingRepository $settingRepository,
        )
    {
        $this->borrowRepository = $borrowRepository;
        $this->settingRepository = $settingRepository;
    }

    /** Handles borrowing of book */
    public function borrowBook(array $data)
    {
        $max_borrows = $this->settingRepository->getRule('max_borrowable');

        if ($this->getBorrowCount($data['borrower_id']) >= $max_borrows) {
            throw new InvalidRequestException("Borrow limit reached. You can only borrow {$max_borrows} books at a time.", 403);
        }

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

        $data = $this->borrowRepository->store($data);

        if (!$data) {
            throw new InvalidRequestException('Book is Unavailable', 404);
        }

        return [
            'message' => 'Book is borrowed by ' . $data['borrower_id'],
            'data' => $data
        ];
    }

    private function getBorrowCount(string $id)
    {

        return $this->borrowRepository->getBorrowed($id);
    }
}

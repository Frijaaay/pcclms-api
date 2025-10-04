<?php

namespace App\Http\Controllers\Api\Books;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\ReportServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\BorrowedBook;

class ReportController extends Controller
{
    /**
      * Constructor property promotion
      */
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private BorrowRepositoryInterface $borrowRepository,
        private ReturnRepositoryInterface $returnRepository,
        private UserRepositoryInterface $userRepository
        ) {}

    /** All report records */
    public function all()
    {
        return $this->handleSuccessResponse($this->reportRepository->all());
    }

    /** Specific record */
    public function show(string $id)
    {
        return $this->handleSuccessResponse($this->reportRepository->findById($id));
    }

    /** Show Borrowed by user */
    public function showByBorrowerId(string $id)
    {
        return $this->handleSuccessResponse($this->userRepository->findBorrowedBooks($id));
    }

    /** All borrowed record by user */
    public function allBorrowed()
    {
        return $this->handleSuccessResponse($this->borrowRepository->all());
    }

    public function showBorrowedById(string $id)
    {
        return $this->handleSuccessResponse($this->borrowRepository->findById($id));
    }

    public function allReturned()
    {
        return $this->handleSuccessResponse($this->returnRepository->all());
    }

    public function showReturnedById(string $id)
    {
        return $this->handleSuccessResponse($this->returnRepository->findById($id));
    }
}

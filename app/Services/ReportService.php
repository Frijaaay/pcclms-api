<?php

namespace App\Services;

use App\Contracts\Repositories\BorrowRepositoryInterface as BorrowRepo;
use App\Contracts\Repositories\ReportRepositoryInterface as ReportRepo;
use App\Contracts\Repositories\ReturnRepositoryInterface as ReturnRepo;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\ReportServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ReportService implements ReportServiceInterface
{

    public function __construct(
        private BorrowRepo $borrowRepo,
        private ReturnRepo $returnRepo,
        private ReportRepo $reportRepo
        ) {}

    private function arrayReturn(string $message, Collection $data)
    {
        return [
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Handles retrieving all records
     */
    public function getAllRecord()
    {
        return $this->arrayReturn('Reports successfully retrieved', $this->reportRepo->all());
    }

    /**
     * Handles retrieving all active borrow records
     */
    public function getActiveBorrows()
    {
        $data = $this->borrowRepo->findActiveBorrows();

        return [
            'message' => 'Active borrow records successfully retrieved',
            'data' => $data
        ];
    }
}

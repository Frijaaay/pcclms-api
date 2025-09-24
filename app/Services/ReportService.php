<?php

namespace App\Services;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Contracts\Services\ReportServiceInterface;
class ReportService extends BaseService implements ReportServiceInterface
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private BorrowRepositoryInterface $borrowRepository,
        private ReturnRepositoryInterface $returnRepository
        )
        {
            parent::__construct($reportRepository);
        }

    public function getAllBorrowed()
    {
        return $this->serviceReturn($this->borrowRepository->all());
    }

    public function getAllReturned()
    {
        return $this->serviceReturn($this->returnRepository->all());
    }

    public function getBorrowedById(string $id)
    {
        return $this->serviceReturn($this->borrowRepository->findById($id));
    }

    public function getReturnedById(string $id)
    {
        return $this->serviceReturn($this->returnRepository->findById($id));
    }

    public function getReportByBorrower(string $id)
    {
        return $this->serviceReturn($this->reportRepository->findByBorrowerId($id));
    }

    public function getBorrowedByBorrower(string $id)
    {

    }

    public function getReturnedByBorrower(string $id)
    {

    }

}

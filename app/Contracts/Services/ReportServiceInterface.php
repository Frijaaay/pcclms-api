<?php

namespace App\Contracts\Services;

interface ReportServiceInterface extends BaseServiceInterface
{
    public function getAllBorrowed();
    public function getAllReturned();
    public function getBorrowedById(string $id);
    public function getReturnedById(string $id);
    public function getReportByBorrower(string $id);
    public function getBorrowedByBorrower(string $id);
    public function getReturnedByBorrower(string $id);
}

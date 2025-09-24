<?php

namespace App\Http\Controllers\Api\Books;

use App\Contracts\Services\ReportServiceInterface;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct(protected ReportServiceInterface $reportService) {}

    /** All report records */
    public function all()
    {
        return $this->returnJsonResponse($this->reportService->getAll());
    }

    public function show(string $id)
    {
        return $this->returnJsonResponse($this->reportService->getById($id));
    }

    public function allBorrowed()
    {
        return $this->returnJsonResponse($this->reportService->getAllBorrowed());
    }

    public function showBorrowedById(string $id)
    {
        return $this->returnJsonResponse($this->reportService->getBorrowedById($id));
    }

    public function allReturned()
    {
        return $this->returnJsonResponse($this->reportService->getAllReturned());
    }

    public function showReturnedById(string $id)
    {
        return $this->returnJsonResponse($this->reportService->getReturnedById($id));
    }
}

<?php

namespace App\Http\Controllers\Api\Books;

use App\Contracts\Services\ReportServiceInterface;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /** Halimaw ka talaga prof x */
    public function __construct(protected ReportServiceInterface $reportService) {}

    /** All report records */
    public function all()
    {
        return $this->returnJsonResponse($this->reportService->getAllRecord());
    }

    /** All currently borrowed books record */
    public function currentlyBorrowed()
    {
        return $this->returnJsonResponse($this->reportService->getActiveBorrows());
    }

}

<?php

namespace App\Http\Controllers\Api\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Contracts\Services\BookServiceInterface;

class BookController extends Controller
{
    /**
     * Dependency Injection
     */
    private BookServiceInterface $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function all()
    {
        return $this->bookService->all();
    }

    public function store(StoreBookRequest $request)
    {
        return $this->bookService->store($request->validated());
    }
}

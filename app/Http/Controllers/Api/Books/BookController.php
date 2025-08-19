<?php

namespace App\Http\Controllers\Api\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\StoreBookRequest;
use App\Contracts\Services\BookServiceInterface;
use App\Http\Requests\DeleteBookRequest;
use App\Http\Requests\UpdateBookRequest;

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

    public function update(int $id, UpdateBookRequest $request)
    {
        return $this->bookService->update($id, $request->validated());
    }

    public function delete(int $id, DeleteBookRequest $_)
    {
        return $this->bookService->delete($id);
    }
}

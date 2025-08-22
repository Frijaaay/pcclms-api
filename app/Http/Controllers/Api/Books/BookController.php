<?php

namespace App\Http\Controllers\Api\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\StoreBookRequest;
use App\Contracts\Services\BookServiceInterface;
use App\Http\Requests\DeleteBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;

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

    public function addNewCopy(int $id, Request $request)
    {
        $book = $this->bookService->addCopy($id, $request->validate(['book_copies_count' => 'required | integer']));

        return response()->json([
            'message' => 'Added ' . $request->book_copies_count . ' copies successfully',
            'book' => $book
        ], 201);
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

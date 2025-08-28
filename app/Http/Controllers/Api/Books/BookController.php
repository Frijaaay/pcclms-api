<?php

namespace App\Http\Controllers\Api\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\AddBookCopyRequest;
use App\Http\Requests\UpdateBookCopyRequest;
use App\Http\Requests\Books\StoreBookRequest;
use App\Contracts\Services\BookServiceInterface;

class BookController extends Controller
{
    private BookServiceInterface $bookService;

    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function all()
    {
        $data = $this->bookService->getAllBooks();

        return response()->json([
            'message' => $data['message'],
            'book_count' => $data['book_count'],
            'books' => $data['books']
        ], 200);
    }

    public function show(int $id)
    {
        $data = $this->bookService->getBookById($id);

        return response()->json([
            'message' => $data['message'],
            'book' => $data['book']
        ], 200);
    }

    public function showBookCopies(int $id)
    {
        $data = $this->bookService->getBookCopies($id);

        return response()->json([
            'message' => $data['message'],
            'book_copies' => $data['book_copies']
        ], 200);
    }

    public function store(StoreBookRequest $request)
    {
        $data = $this->bookService->createBook($request->validated());

        return response()->json([
            'message' => $data['message'],
            'book' => $data['book']
        ], 201);
    }

    public function storeBookCopy(int $id, AddBookCopyRequest $request)
    {
        $data = $this->bookService->createBookCopy($id, $request->validated());

        return response()->json([
            'message' => $data['message'],
            'book' => $data['book']
        ], 201);
    }

    public function update(int $id, UpdateBookRequest $request)
    {
        $data = $this->bookService->updateBook($id, $request->validated());

        return response()->json([
            'message' => $data['message'],
            'book' => $data['book']
        ], 200);
    }

    public function updateBookCopy(int $id, int $copy_id, UpdateBookCopyRequest $request)
    {
        $data = $this->bookService->updateBookCopy($id, $copy_id, $request->validated());

        return response()->json([
            'message' => $data['message'],
            'book_copy' => $data['book_copy']
        ], 200);
    }

    public function delete(int $id, DeleteBookRequest $_)
    {
        $data = $this->bookService->deleteBook($id);

        return response()->json([
            'message' => $data['message']
        ]);
    }
}

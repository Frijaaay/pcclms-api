<?php

namespace App\Http\Controllers\Api\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\DeleteBookRequest;
use App\Http\Requests\ManageBorrowRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Http\Requests\Books\AddBookCopyRequest;
use App\Http\Requests\Books\UpdateBookCopyRequest;
use App\Http\Requests\Books\StoreBookRequest;
use App\Contracts\Services\BookServiceInterface;
use App\Contracts\Services\BorrowServiceInterface;
use App\Contracts\Services\ReturnServiceInterface;
use App\Http\Requests\ManageReturnRequest;

class BookController extends Controller
{
    private BookServiceInterface $bookService;
    private BorrowServiceInterface $borrowService;
    private ReturnServiceInterface $returnService;

    public function __construct(BookServiceInterface $bookService,
    BorrowServiceInterface $borrowService,
    ReturnServiceInterface $returnService)
    {
        $this->bookService = $bookService;
        $this->borrowService = $borrowService;
        $this->returnService = $returnService;
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

    public function borrowBook(ManageBorrowRequest $request)
    {
        $response = $this->borrowService->borrowBook($request->validated());

        return response()->json([
            'message' => $response['message'],
            'borrowed_book' => $response['data']
        ], 201);
    }

    public function returnBook(ManageReturnRequest $request)
    {
        // $response = $this->returnService->;
    }
}

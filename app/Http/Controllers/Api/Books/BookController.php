<?php

namespace App\Http\Controllers\Api\Books;

use App\Contracts\Repositories\BookRepositoryInterface;
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
    /**
      * Constructor property promotion
      */
    public function __construct(
        private BookServiceInterface $bookService,
        private BookRepositoryInterface $bookRepository,
        private BorrowServiceInterface $borrowService,
        private ReturnServiceInterface $returnService
        ) {}

        /**
         * Get all book
         */
    public function all()
    {
        return $this->handleSuccessResponse($this->bookRepository->all());
    }

    /**
     * Get book by id
     */
    public function show(int $id)
    {
        return $this->handleSuccessResponse($this->bookRepository->findById($id));
    }

    /**
     * Get book copies
     */
    public function showBookCopies(int $id)
    {
        return $this->handleSuccessResponse($this->bookRepository->findBookCopies($id));
    }

    /**
     * Create book
     */
    public function store(StoreBookRequest $request)
    {
        $response = $this->bookService->create($request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }

    /**
     * Create book copy
     */
    public function storeBookCopy(int $id, AddBookCopyRequest $request)
    {
        $response = $this->bookService->createBookCopy($id, $request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }

    /**
     * Update book
     */
    public function update(int $id, UpdateBookRequest $request)
    {
        $response = $this->bookService->update($id, $request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Update book copy
     */
    public function updateBookCopy(int $id, int $copy_id, UpdateBookCopyRequest $request)
    {
        $response = $this->bookService->updateBookCopy($id, $copy_id, $request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Delete book
     */
    public function delete(int $id, DeleteBookRequest $_)
    {
        $response = $this->bookService->delete($id);
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Create borrowed book
     */
    public function borrowBook(ManageBorrowRequest $request)
    {
        $response = $this->borrowService->borrowBook($request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }

    /**
     * Create returned book
     */
    public function returnBook(ManageReturnRequest $request)
    {
        $response = $this->returnService->returnBook($request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }
}

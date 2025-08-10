<?php

namespace App\Http\Controllers\Api\Books;

use App\Models\Book;
use App\Models\BookCopy;
use App\Contracts\Services\BookServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}

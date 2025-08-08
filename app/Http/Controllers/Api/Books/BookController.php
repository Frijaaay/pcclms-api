<?php

namespace App\Http\Controllers\Api\Books;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::withCount('bookCopies')
        ->get();

        return response()->json([
            'book_count' => count($books),
            'book' => $books
        ]);
    }

    public function bookCopy()
    {
        $copies = BookCopy::all();

        return response()->json([
            'bookCopy' => $copies

        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function books()
    {
        $books = Book::withCount('bookCopies')->get();

        return response()->json([
            'book' => $books,
            'book_count' => count($books)
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

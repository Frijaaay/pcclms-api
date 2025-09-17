<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BorrowedBook;
use App\Models\ReturnedBook;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creates 20 books first
        Book::factory(20)->create();

        $books = Book::pluck('id');

        // Creates 1-10 copies of each book
        foreach ($books as $book) {
            BookCopy::factory(fake()->numberBetween(0, 10))->create([
                'book_id' => $book
            ]);
        }

        /** Seeder for borrowed_books
         * and returned_books
         * table
        */
        // $borrowed_books = BorrowedBook::factory(50)->create();

        // $borrowed_books->each(function ($borrowed_books) {
        //     if (fake()->boolean(75)) {
        //         ReturnedBook::factory()->create([
        //             'borrowed_book_id' => $borrowed_books->id,
        //             'returned_at' => fake()->dateTimeBetween($borrowed_books->borrowed_at, $borrowed_books->due_at),
        //         ]);
        //     }
        // });
    }
}

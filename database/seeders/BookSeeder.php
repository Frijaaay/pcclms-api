<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1-20 copy each book in db
        // Creates 20 books first
        Book::factory(20)->create();

        $books = Book::pluck('id');

        // Creates 1-20 copies of each book
        foreach ($books as $book) {
            BookCopy::factory(fake()->numberBetween(0, 10))->create([
                'book_id' => $book
            ]);
        }
    }
}

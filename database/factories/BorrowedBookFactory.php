<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\BookCopy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowedBook>
 */
class BorrowedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowed_at = $this->faker->dateTime();

        return [
            'borrower_id' => User::inRandomOrder()->first()->id,
            'book_copy_id' => BookCopy::where('status', 'Available')->inRandomOrder()->first()->id,
            'librarian_id' => User::where('user_type_id', 2)->inRandomOrder()->first()->id,
            'borrowed_at' => $borrowed_at,
            'due_at' => Carbon::instance($borrowed_at)->addDays(7),
        ];
    }
}

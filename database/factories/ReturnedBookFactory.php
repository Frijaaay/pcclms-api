<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BorrowedBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReturnedBook>
 */
class ReturnedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'librarian_id' => User::where('user_type_id', 2)->inRandomOrder()->first()->id,
        ];
    }
}

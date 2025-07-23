<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCopy>
 */
class BookCopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'condition' => $condition = fake()->randomElement(['Good', 'Slightly Damaged', 'Severely Damaged', 'Lost']),
            'status' => match($condition) {
                'Good', 'Slightly Damaged' => 'Available',
                'Severely Damaged', 'Lost' => 'Unavailable'
            }
        ];
    }
}

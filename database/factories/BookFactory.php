<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'author' => fake()->name(),
            'author_1' => fake()->optional()->name(),
            'author_2' => fake()->optional()->name(),
            'author_3' => fake()->optional()->name(),
            'isbn' => fake()->unique()->isbn13(),
            'category' => fake()->randomElement(['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography']),
        ];
    }
}

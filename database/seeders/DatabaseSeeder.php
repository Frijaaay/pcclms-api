<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create User Types
        $user_type = ['admin', 'librarian', 'borrower'];
        foreach ($user_type as $type) {
            UserType::factory()->create([
                'name' => $type,
            ]);
        }

        // Default Admin User
        User::factory()->create([
            'user_type_id' => 1,
            'id_number' => '2021-102369',
            'name' => 'Jay Cortez Jr.',
            'email' => 'test@example.com',
            'password' => Hash::make('admin123'),
            'type' => 'Employee',
            'department' => 'IT Faculty',
            'status' => 'Active'
        ]);

        // Create default Librarian
        User::factory()->create([
            'user_type_id' => 2,
            'id_number' => '2021-102368',
            'name' => 'Jay Librarian',
            'email' => 'testLibrarian@example.com',
            'password' => Hash::make('admin123'),
            'type' => 'Employee',
            'department' => 'Faculty',
            'status' => 'Active'
        ]);

        // Create default borrower
        User::factory()->create([
            'user_type_id' => 3,
            'id_number' => '2021-102367',
            'name' => 'Jay Borrower',
            'email' => 'testBorrower@example.com',
            'password' => Hash::make('admin123'),
            'type' => 'College',
            'department' => 'CEAT',
            'status' => 'Active'
        ]);

        // Create 10 Librarian
        User::factory(10)->create([
            'user_type_id' => 2,
            'type' => 'Employee'
        ]);

        // Create 10 Borrowers
        User::factory(10)->create(['user_type_id' => 3]);

        // Calls the book seeder to automatically run right after this seeder
        $this->call([
            BookSeeder::class
        ]);
    }
}

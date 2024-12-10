<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@tes',
            'role' => 'user',
            'password' => bcrypt('user'),
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@tes',
            'password' => bcrypt('admin'),
        ]);

        Book::create([
            'type' => 'komik',
            'name' => 'Naruto',
            'author' => 'Masashi Kishimoto',
            'year' => 2000,
            'stock' => 100,
        ]);
    }
}
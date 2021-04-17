<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory()
            ->has(Comment::factory()->count(3))
            ->create();
    }
}

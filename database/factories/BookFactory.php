<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Vue.js&Nuxt.js超入門',
            'price' => random_int(1000, 7000),
            'author' => $this->faker->name,
            'publisher' => '秀和システム',
            'published' => now()->subDay(random_int(1, 1000)),
            'image' => 'http://books.google.com/books/content?id=jBqtDwAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api'
        ];
    }
}

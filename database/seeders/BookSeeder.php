<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    protected const COUNT = 200;

    /**
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < self::COUNT; $i++) {
            Book::create([
                'author_id' => rand(1, 100),
                'title' => $faker->sentence(3),
                'is_borrowed' => $faker->boolean(30), // 30 % šanca že je požičaná
            ]);
        }
    }
}


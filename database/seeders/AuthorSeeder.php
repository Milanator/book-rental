<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    protected const COUNT = 100;

    /**
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < self::COUNT; $i++) {
            Author::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
            ]);
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Types;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');
        for ($i = 0; $i < 100; $i++) {
            Types::create(
                [
                    'name' => $faker->word(),
                    'description' => $faker->sentences(1, true),
                ]
            );
        }
    }
}

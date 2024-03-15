<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supply;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');
        for ($i = 0; $i < 100; $i++) {
            Supply::create(
                [
                    'name' => $faker->name(),
                    'cnpj' => $faker->cnpj(),
                ]
            );
        }
    }
}

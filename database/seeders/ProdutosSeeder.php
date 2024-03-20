<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $brand = Brand::select('id')->inRandomOrder()->limit(1)->first();
            Product::create(
                [
                    'nome' => $faker->name(),
                    'valor' => $faker->randomNumber(2),
                    'brand_id' => $brand->id,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductTypes;
use Illuminate\Database\Seeder;
use App\Models\Types;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get 100
        $types = Types::all()->random(100);
        $products = Product::all()->random(100);
        
        for ($i = 0; $i < 100; $i++) {
            ProductTypes::create(
                [
                    'type_id' => $types[$i]->id,
                    'product_id' => $products[$i]->id
                ]
            );
        }
    }
}

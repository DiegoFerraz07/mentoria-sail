<?php

namespace Database\Seeders;

use App\Models\ProductTypes;
use App\Models\Produto;
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
        $products = Produto::all()->random(100);
        
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

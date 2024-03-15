<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductBrand;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get 100
        $brand = Brand::all()->random(100);
        $products = Product::all()->random(100);
        
        for ($i = 0; $i < 100; $i++) {
            ProductBrand::create(
                [
                    'brand_id' => $brand[$i]->id,
                    'product_id' => $products[$i]->id
                ]
            );
        }
    }
}

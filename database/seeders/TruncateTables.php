<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class TruncateTables extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // drop all data
        DB::table('users')->truncate();
        DB::table('cliente')->truncate();
        DB::table('product_types')->truncate();
        DB::table('produtos')->truncate();
        DB::table('types')->truncate();
        DB::table('brand')->truncate();
        DB::table('fornecedores')->truncate();
        DB::table('orders')->truncate();
    }
}

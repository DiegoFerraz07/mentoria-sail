<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
         $this->call([ClientSeeder::class]);
         $this->call([ProdutosSeeder::class]);
         $this->call([SupplySeeder::class]);
         $this->call([TypeSeeder::class]);
         $this->call([ProductTypeSeeder::class]);
    }
}

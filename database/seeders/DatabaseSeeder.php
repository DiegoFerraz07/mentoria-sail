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
        echo "Truncating tables...\n";
        try {
            DB::statement("SET foreign_key_checks=0");
            $this->call([TruncateTables::class]);
            DB::statement("SET foreign_key_checks=1");
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage()  . $e->getTraceAsString() . "\n";
            return;
        }
        echo "Tables truncated successfully.\n\n";
        
        echo "Seeding database...\n";
        try {
            $this->call([UsersTableSeeder::class]);
            $this->call([ClientSeeder::class]);
            $this->call([BrandSeeder::class]);
            $this->call([ProdutosSeeder::class]);
            $this->call([SupplySeeder::class]);
            $this->call([TypeSeeder::class]);
            $this->call([ProductTypeSeeder::class]);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage()  . $e->getTraceAsString() . "\n";
            return;
        }

        echo "Database seeded successfully.\n";
    }
}

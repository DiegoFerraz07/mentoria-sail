<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $allSuppliesDuplicates = DB::table('fornecedores')
            ->select('cnpj')
            ->groupBy('cnpj')
            ->havingRaw('count(*) > 1')
            ->get();

        foreach ($allSuppliesDuplicates as $supply) {
            $duplicates = DB::table('fornecedores')
                ->where('cnpj', $supply->cnpj)
                ->get();

            // show in terminal
            foreach ($duplicates as $duplicate) {
                // alterando cnpj para cnpj + uuid support 18 characters
                DB::table('fornecedores')
                    ->where('id', $duplicate->id)
                    ->update(['cnpj' => 'duplicate_' . Str::substr(Str::uuid(), 0, 6)]);
            }
        }


        Schema::table('fornecedores', function (Blueprint $table) { 
            $table->string('cnpj', 18)->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fornecedores', function (Blueprint $table) { 
            $table->string('cnpj', 18)->nullable(false);
        });
    }
};

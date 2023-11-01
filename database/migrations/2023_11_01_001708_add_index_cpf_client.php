<?php

use Database\Seeders\ClientSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('cliente')->truncate();
        Schema::table('cliente', function (Blueprint $table) {
            if (collect(DB::select("SHOW INDEXES FROM cliente"))->pluck('Key_name')->contains('cliente_cpf_unique')) {
                $table->dropUnique('cliente_cpf_unique');
            }

            $table->string('cpf', 14)
                ->unique('cliente_cpf_unique')
                ->nullable(false)
                ->change();
        });
            Artisan::call('db:seed --class=ClientSeeder --force');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

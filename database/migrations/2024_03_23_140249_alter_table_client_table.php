<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->string('cnpj', 18)
                ->nullable()
                ->after('cpf');

            $table->json('address')
                ->nullable()
                ->after('email');

            $table->string('cpf', 14)
                ->nullable()
                ->unique(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // remove column cnpj table cliente
        Schema::table('cliente', function (Blueprint $table) {
            $table->dropColumn('cnpj');
            $table->dropColumn('address');
        });
    }
};

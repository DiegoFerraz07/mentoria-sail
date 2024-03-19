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
        // add column email in table cliente
        Schema::table('cliente', function (Blueprint $table) {
            $table->string('email')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // remove column email in table cliente
        Schema::table('cliente', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};

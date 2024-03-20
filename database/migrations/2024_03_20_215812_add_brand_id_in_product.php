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
        Schema::table('produtos', function (Blueprint $table) {
            $table->bigInteger('brand_id')->unsigned()->nullable()->default(null);
            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brand')
                  ->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign('brand_id');
            $table->dropColumn('brand_id');
        });
    }
};

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
        Schema::create('product_brand', function (Blueprint $table) {
            $table->id();      
            $table->bigInteger('brand_id')->unsigned()->notnull();
            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brand')
                  ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->notnull();
            $table->foreign('product_id')
                  ->references('id')
                  ->on('produtos')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_brand');
    }
};

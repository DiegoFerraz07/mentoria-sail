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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_order', 15)->autoIncrement(false);
            $table->string('description_order', 512);
            $table->decimal('tax_order', 10,2);
            $table->decimal('icms_order', 10,2);
            $table->decimal('total_value_order', 10,2);
            $table->string('obs_order', 512);
            $table->string('name_supply', 200);
            $table->string('cnpj_supply', 18);
            $table->string('name_client', 200);
            $table->string('cpf_client', 14)->nullable();
            $table->string('cnpj_client', 18)->nullable();
            $table->text('address_client');
            $table->json('orders_itens');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

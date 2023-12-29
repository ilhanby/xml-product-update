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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment('Ürün ID')->index();
            $table->string('name')->comment('Ürün Adı')->nullable();
            $table->text('description')->comment('Ürün Açıklaması')->nullable();
            $table->decimal('price', 10, 2)->comment('Ürün Fiyatı')->default(0.00);
            $table->integer('quantity')->comment('Ürün Miktarı')->default(0);
            $table->string('photo_url')->comment('Ürün Fotoğrafı')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

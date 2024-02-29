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
        Schema::create('achat_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->timestamp('date');
            $table->boolean('isValid');
            $table->foreignId('productId')->constrained('products');
            $table->foreignId('achatId')->constrained('bon_d_achats');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achat_items');
    }
};

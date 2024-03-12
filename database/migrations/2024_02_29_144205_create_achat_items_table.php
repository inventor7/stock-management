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
            $table->string('id')->primary();
            $table->integer('quantity');
            $table->string('product_id');
            $table->string('achat_id')->nullable()->default(null);  
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('achat_id')->references('id')->on('achats');
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

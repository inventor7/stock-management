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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->timestamp('date');
            $table->boolean('isShipped');
            $table->foreignId('takenBy')->constrained('workers');
            $table->foreignId('shippedBy')->constrained('workers');
            $table->foreignId('orderId')->constrained('orders');
            $table->foreignId('productId')->constrained('products');
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

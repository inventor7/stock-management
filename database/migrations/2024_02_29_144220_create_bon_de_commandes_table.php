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
        Schema::create('bon_de_commandes', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->timestamp('date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_de_commandes');
    }
};

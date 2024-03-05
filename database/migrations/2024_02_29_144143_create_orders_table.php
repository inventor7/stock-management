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
            $table->string('id')->primary();
            $table->string('status');
            $table->string('adress');
            $table->string('wilaya');
            $table->string('commune');
            $table->string('note');
            $table->string('client_id');
            $table->string('leader_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('leader_id')->references('id')->on('workers');
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

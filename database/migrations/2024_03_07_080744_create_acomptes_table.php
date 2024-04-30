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
        Schema::create('acomptes', function (Blueprint $table) {
            $table->string('id')->primary();
            
            $table->string('bon_acompte_id');
            $table->foreign('bon_acompte_id')->references('id')->on('bon_acomptes');

            $table->string('worker_id');
            $table->foreign('worker_id')->references('id')->on('workers');

            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acomptes');
    }
};

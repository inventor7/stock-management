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
        Schema::create('bon_d_achats', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('bon_d_achats_id');
            $table->foreign('bon_d_achats_id')->references('id')->on('achats');
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
        Schema::dropIfExists('bon_d_achats');
    }
};

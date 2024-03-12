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
        Schema::create('véhicules', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nom');
            $table->string('année');
            $table->string('status');
            $table->integer('cp');
            $table->integer('vp');
            $table->string('chauffeur_id')->nullable()->default(null);
            $table->foreign('chauffeur_id')->references('id')->on('workers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('véhicules');
    }
};

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
        Schema::create('controle_techniques', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('véhicule_id');
            $table->foreign('véhicule_id')->references('id')->on('véhicules');
            $table->date('ancien_controle');
            $table->date('futur_controle');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controle_techniques');
    }
};

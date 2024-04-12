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
        Schema::create('achats', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->decimal('price')->nullable()->default(null);

            $table->string('fournisseur_id')->nullable()->default(null);
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs');

            $table->string('chauffeur_id');
            $table->foreign('chauffeur_id')->references('id')->on('workers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achats');
    }
};

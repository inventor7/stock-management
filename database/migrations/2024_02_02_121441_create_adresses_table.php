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
        Schema::create('adresses', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('commune_name');
            $table->string('commune_name_ascii');
            $table->string('daira_name');
            $table->string('daira_name_ascii');
            $table->string('wilaya_name');
            $table->string('wilaya_name_ascii');
            $table->string('wilaya_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};

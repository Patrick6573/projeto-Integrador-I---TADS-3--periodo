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
        Schema::create('telefone_usuario', function (Blueprint $table) {
            $table->integer('id_telefone_usuario')->primary();
            $table->string('telefone_usuario1', 20)->nullable();
            $table->string('telefone_usuario2', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefone_usuario');
    }
};

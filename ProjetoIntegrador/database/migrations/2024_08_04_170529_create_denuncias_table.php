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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->integer('id_denuncia')->primary();
            $table->string('motivo_denuncia', 50)->nullable();
            $table->string('descricao_denuncia')->nullable();
            $table->integer('id_usuario_denunciado')->nullable();
            $table->integer('id_usuario_denunciante')->nullable();
            $table->integer('fk_usuarios_id_usuario')->nullable()->index('fk_denuncias_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};

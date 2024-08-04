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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id_usuario')->primary();
            $table->string('rua', 20)->nullable();
            $table->integer('numero')->nullable();
            $table->string('cidade', 20)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('logradouro', 20)->nullable();
            $table->string('estado', 20)->nullable();
            $table->string('complemento', 50)->nullable();
            $table->string('ponto_referencia', 50)->nullable();
            $table->string('nome_usuario', 50)->nullable();
            $table->string('email_usuario', 50)->nullable();
            $table->string('senha_usuario', 20)->nullable();
            $table->string('tipo_usuario', 20)->nullable();
            $table->date('data_nascimento_usuario')->nullable();
            $table->date('data_cadastro_usuario')->nullable();
            $table->string('foto_usuario', 100)->nullable();
            $table->integer('fk_telefone_usuario_id_telefone_usuario')->nullable()->index('fk_usuarios_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

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
            $table->string('nome_usuario', 50);
            $table->string('email_usuario', 100);
            $table->string('senha_usuario', 50);
            $table->string('tipo_usuario', 20);
            $table->date('data_nascimento_usuario')->nullable();
            $table->date('data_cadastro_usuario');
            $table->string('foto_usuario', 100)->nullable();
            $table->string('status_conta', 50);
            $table->integer('fk_telefone_usuario_id_telefone')->nullable()->index('fk_usuarios_2');
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

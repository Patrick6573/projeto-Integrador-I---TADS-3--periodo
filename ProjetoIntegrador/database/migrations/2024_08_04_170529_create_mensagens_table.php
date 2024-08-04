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
        Schema::create('mensagens', function (Blueprint $table) {
            $table->integer('id_mensagem')->primary();
            $table->date('data_envio')->nullable();
            $table->time('hora_envio')->nullable();
            $table->integer('id_usuario_remetente')->nullable();
            $table->integer('id_usuario_destinatario')->nullable();
            $table->string('conteudo_mensagem')->nullable();
            $table->date('hora_recebimento')->nullable();
            $table->time('data_recebimento')->nullable();
            $table->integer('fk_usuarios_id_usuario')->nullable()->index('fk_mensagens_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};

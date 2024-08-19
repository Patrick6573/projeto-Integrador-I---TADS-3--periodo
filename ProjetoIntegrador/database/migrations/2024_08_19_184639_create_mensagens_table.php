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
            $table->date('data_envio');
            $table->time('hora_envio');
            $table->string('conteudo_mensagem', 500);
            $table->time('hora_recebimento')->nullable();
            $table->date('data_recebimento')->nullable();
            $table->string('status_mensagem', 50)->nullable();
            $table->integer('fk_usuarios_id_usuario_remetente')->nullable()->index('fk_mensagens_2');
            $table->integer('fk_usuarios_id_usuario_destinatario')->nullable()->index('fk_mensagens_3');
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

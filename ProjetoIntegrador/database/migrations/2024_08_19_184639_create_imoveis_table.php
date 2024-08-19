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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->integer('id_imovel')->primary();
            $table->string('logradouro', 50);
            $table->integer('numero');
            $table->string('cep', 20);
            $table->string('cidade', 50);
            $table->string('estado', 20);
            $table->string('complemento', 50)->nullable();
            $table->string('ponto_referencia', 50)->nullable();
            $table->integer('numero_quartos');
            $table->integer('numero_banheiros');
            $table->integer('tamanho_imovel');
            $table->float('valor_aluguel');
            $table->string('descricao_imovel', 500)->nullable();
            $table->string('tipo_imovel', 50);
            $table->string('status_imovel', 50);
            $table->string('titulo_imovel', 50)->nullable();
            $table->integer('fk_usuarios_id_usuario')->nullable()->index('fk_imoveis_4');
            $table->integer('fk_videos_imovel_id_video')->nullable()->index('fk_imoveis_2');
            $table->integer('fk_fotos_imovel_id_foto')->nullable()->index('fk_imoveis_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};

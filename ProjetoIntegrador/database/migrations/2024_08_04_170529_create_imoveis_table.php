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
            $table->integer('id_imovel');
            $table->string('logradouro', 50)->nullable();
            $table->string('rua', 50)->nullable();
            $table->integer('numero')->nullable();
            $table->string('cep', 50)->nullable();
            $table->string('cidade', 20)->nullable();
            $table->string('estado', 50)->nullable();
            $table->string('complemento', 50)->nullable();
            $table->string('ponto_referencia', 50)->nullable();
            $table->integer('numero_quartos')->nullable();
            $table->integer('numero_banheiros')->nullable();
            $table->integer('tamanho_imovel')->nullable();
            $table->double('valor_aluguel')->nullable();
            $table->string('descricao_imovel')->nullable();
            $table->string('tipo_imovel', 20)->nullable();
            $table->string('fk_foto_imovel_id_foto', 100)->index('fk_imoveis_4');
            $table->integer('fk_usuarios_id_usuario')->nullable()->index('fk_imoveis_2');
            $table->integer('fk_videos_imovel_id_video')->nullable()->index('fk_imoveis_3');

            $table->primary(['id_imovel', 'fk_foto_imovel_id_foto']);
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

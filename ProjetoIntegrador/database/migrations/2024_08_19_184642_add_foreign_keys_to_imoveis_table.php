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
        Schema::table('imoveis', function (Blueprint $table) {
            $table->foreign(['fk_videos_imovel_id_video'], 'FK_imoveis_2')->references(['id_video'])->on('videos_imovel')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['fk_fotos_imovel_id_foto'], 'FK_imoveis_3')->references(['id_foto'])->on('fotos_imovel')->onUpdate('restrict')->onDelete('no action');
            $table->foreign(['fk_usuarios_id_usuario'], 'FK_imoveis_4')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imoveis', function (Blueprint $table) {
            $table->dropForeign('FK_imoveis_2');
            $table->dropForeign('FK_imoveis_3');
            $table->dropForeign('FK_imoveis_4');
        });
    }
};

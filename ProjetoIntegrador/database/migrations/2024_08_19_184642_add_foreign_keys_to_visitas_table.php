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
        Schema::table('visitas', function (Blueprint $table) {
            $table->foreign(['fk_usuarios_id_proprietario'], 'FK_visitas_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['fk_usuarios_id_visitante'], 'FK_visitas_3')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['fk_imoveis_id_imovel'], 'FK_visitas_4')->references(['id_imovel'])->on('imoveis')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitas', function (Blueprint $table) {
            $table->dropForeign('FK_visitas_2');
            $table->dropForeign('FK_visitas_3');
            $table->dropForeign('FK_visitas_4');
        });
    }
};

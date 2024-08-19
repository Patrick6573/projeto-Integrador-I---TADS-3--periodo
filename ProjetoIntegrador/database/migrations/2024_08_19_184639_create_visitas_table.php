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
        Schema::create('visitas', function (Blueprint $table) {
            $table->integer('id_visita')->primary();
            $table->date('data_visita');
            $table->time('hora_visita');
            $table->string('status_solicitacao', 50);
            $table->string('status_visita', 50)->nullable();
            $table->integer('fk_usuarios_id_visitante')->nullable()->index('fk_visitas_3');
            $table->integer('fk_usuarios_id_proprietario')->nullable()->index('fk_visitas_2');
            $table->integer('fk_imoveis_id_imovel')->nullable()->index('fk_visitas_4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};

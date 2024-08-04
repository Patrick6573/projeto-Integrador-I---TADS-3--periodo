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
        Schema::table('mensagens', function (Blueprint $table) {
            $table->foreign(['fk_usuarios_id_usuario'], 'FK_mensagens_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensagens', function (Blueprint $table) {
            $table->dropForeign('FK_mensagens_2');
        });
    }
};

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
        Schema::create('fotos_imovel', function (Blueprint $table) {
            $table->date('data_envio')->nullable();
            $table->string('url_foto', 100);
            $table->integer('id_foto')->primary();
            $table->time('hora_envio')->nullable();
            $table->string('nome_foto', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_imovel');
    }
};

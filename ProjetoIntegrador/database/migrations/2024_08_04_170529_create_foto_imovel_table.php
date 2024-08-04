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
        Schema::create('foto_imovel', function (Blueprint $table) {
            $table->string('id_foto', 100)->primary();
            $table->date('data_envio')->nullable();
            $table->string('url_foto', 100)->nullable();
            $table->time('hora_envio')->nullable();
            $table->string('nome_foto', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_imovel');
    }
};

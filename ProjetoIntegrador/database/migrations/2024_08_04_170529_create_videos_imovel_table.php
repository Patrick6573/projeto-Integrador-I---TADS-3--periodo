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
        Schema::create('videos_imovel', function (Blueprint $table) {
            $table->integer('id_video')->primary();
            $table->string('nome_video', 100)->nullable();
            $table->string('url_video', 100)->nullable();
            $table->date('data_envio')->nullable();
            $table->time('hora_envio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos_imovel');
    }
};

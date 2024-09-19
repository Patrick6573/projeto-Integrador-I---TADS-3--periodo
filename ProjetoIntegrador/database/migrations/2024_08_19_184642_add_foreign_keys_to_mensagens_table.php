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
        Schema::table('menssages', function (Blueprint $table) {
            $table->foreign(['fk_id_user_from'], 'fk_menssages_2')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['fk_id_user_to'], 'fk_menssages_3')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menssages', function (Blueprint $table) {
            $table->dropForeign('fk_menssages_2');
            $table->dropForeign('fk_menssages_3');
        });
    }
};

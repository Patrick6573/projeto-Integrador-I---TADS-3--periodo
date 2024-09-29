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
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign(['fk_id_user_from'], 'fk_messages_2')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['fk_id_user_to'], 'fk_messages_3')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('fk_messages_2');
            $table->dropForeign('fk_messages_3');
        });
    }
};

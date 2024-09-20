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
        Schema::table('visits', function (Blueprint $table) {
            $table->foreign(['fk_id_owner'], 'fk_visits_2')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['fk_id_visitor'], 'fk_visits_3')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['fk_id_property'], 'fk_visits_4')->references(['id'])->on('propertys')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign('fk_visits_2');
            $table->dropForeign('fk_visits_3');
            $table->dropForeign('fk_visits_4');
        });
    }
};

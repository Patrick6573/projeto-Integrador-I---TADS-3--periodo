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
        Schema::table('users_phone', function (Blueprint $table) {
            $table->foreign(['fk_id_user'], 'fk_users_phone')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('property_files', function (Blueprint $table) {
            $table->foreign(['fk_id_property'], 'fk_property_files')->references(['id'])->on('propertys')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_phone', function (Blueprint $table) {
            $table->dropForeign('fk_users_phone');
        });
        Schema::table('property_files', function (Blueprint $table) {
            $table->dropForeign('fk_property_files');
        });

        
    }
};

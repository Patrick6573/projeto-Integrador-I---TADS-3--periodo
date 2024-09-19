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
        Schema::table('propertys', function (Blueprint $table) {
            $table->foreign(['fk_id_video'], 'fk_propertys_2')->references(['id_video'])->on('property_videos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['fk_id_photo'], 'fk_propertys_3')->references(['id_photo'])->on('property_photos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['fk_id_user'], 'fk_propertys_4')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propertys', function (Blueprint $table) {
            $table->dropForeign('fk_propertys_2');
            $table->dropForeign('fk_propertys_3');
            $table->dropForeign('fk_propertys_4');
        });
    }
};

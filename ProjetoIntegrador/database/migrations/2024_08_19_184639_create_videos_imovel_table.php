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
        Schema::create('property_videos', function (Blueprint $table) {
            $table->string('video_name', 100);
            $table->string('video_url', 100);
            $table->date('shipping_date')->nullable();
            $table->uuid('id_video')->primary();
            $table->time('shipping_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_videos');
    }
};

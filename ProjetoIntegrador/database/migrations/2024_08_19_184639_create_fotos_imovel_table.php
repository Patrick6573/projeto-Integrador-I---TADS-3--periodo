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
        Schema::create('property_photos', function (Blueprint $table) {
            $table->date('shipping_date')->nullable();
            $table->string('photo_url', 100);
            $table->uuid('id_photo')->primary();
            $table->time('shipping_time')->nullable();
            $table->string('name_photo', 100);
            $table->uuid('fk_id_property')->nullable()->index('fk_property_photos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_photos');
    }
};

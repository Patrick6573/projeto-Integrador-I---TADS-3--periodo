<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('propertys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('street', 50);
            $table->integer('number');
            $table->string('neighborhood', 50);
            $table->string('zip_code', 20);
            $table->string('city', 50);
            $table->string('state', 20);
            $table->string('complement', 50)->nullable();
            $table->string('reference_point', 50)->nullable();
            $table->integer('number_rooms');
            $table->integer('number_bathrooms');
            $table->integer('property_size');
            $table->decimal('rental_value', 8,2);
            $table->string('property_description', 500)->nullable();
            $table->string('property_type', 50);
            $table->string('property_status', 50);
            $table->string('property_title', 50)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 11, 7)->nullable();

            $table->uuid('fk_id_user')->nullable()->index('fk_propertys_4');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propertys');
    }
};

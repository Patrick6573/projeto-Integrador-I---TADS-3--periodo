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
        Schema::create('menssages', function (Blueprint $table) {
            $table->uuid('id_menssage')->primary();
            $table->date('shipping_date');
            $table->time('shipping_time');
            $table->string('content_menssage', 500);
            $table->time('time_received')->nullable();
            $table->date('date_received')->nullable();
            $table->uuid('fk_id_user_from')->nullable()->index('fk_menssages_2');
            $table->uuid('fk_id_user_to')->nullable()->index('fk_menssages_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menssages');
    }
};

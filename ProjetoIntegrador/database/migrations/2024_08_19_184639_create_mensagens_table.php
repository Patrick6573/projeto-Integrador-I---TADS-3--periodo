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
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('shipping_date');
            $table->time('shipping_time');
            $table->string('content', 500);
            $table->time('time_received')->nullable();
            $table->date('date_received')->nullable();
            $table->uuid('fk_id_user_from')->nullable()->index('fk_messages_2');
            $table->uuid('fk_id_user_to')->nullable()->index('fk_messages_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

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
        Schema::create('users_phone', function (Blueprint $table) {
            $table->uuid('id_phone')->primary();
            $table->string('user_phone', 20)->nullable();
            $table->string('user_phone2', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_phone');
    }
};

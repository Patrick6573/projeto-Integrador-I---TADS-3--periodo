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
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id_visit')->primary();
            $table->date('date_visit');
            $table->time('time_visit');
            $table->string('request_status', 50);
            $table->string('status_visit', 50)->nullable();
            $table->uuid('fk_id_visitor')->nullable()->index('fk_visits_3');
            $table->uuid('fk_id_owner')->nullable()->index('fk_visits_2');
            $table->uuid('fk_id_property')->nullable()->index('fk_visits_4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

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
        Schema::create('service_windows', function (Blueprint $table) {
            $table->id();
            $table->string("line_code");
            $table->foreign("line_code")->references("code")->on("lines");
            $table->time("start_time");
            $table->time("end_time");
            $table->integer("interval_minutes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_windows');
    }
};

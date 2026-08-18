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
        Schema::create('lines', function (Blueprint $table) {
            $table->string("code")->primary();
            $table->string("name");
            $table->string("status");
            $table->string("station_a_code");
            $table->string("station_b_code");
            $table->foreign("station_a_code")->references("code")->on("stations");
            $table->foreign("station_b_code")->references("code")->on("stations");
            $table->integer("seat_capacity");
            $table->integer("crossing_minutes");
            $table->decimal("fare_cny",10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lines');
    }
};

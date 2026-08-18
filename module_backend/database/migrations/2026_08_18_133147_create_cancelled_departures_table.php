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
        Schema::create('cancelled_departures', function (Blueprint $table) {
            $table->id();
            $table->string("line_code");
            $table->foreign("line_code")->references("code")->on("lines");
            $table->date("departure_date");
            $table->time("departure_time");
            $table->string("departure_station_code");
            $table->foreign("departure_station_code")->references("code")->on("stations");
            $table->string("reason")->nullable();
            $table->timestamp("cancelled_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_departures');
    }
};

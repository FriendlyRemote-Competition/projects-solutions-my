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
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("line_code");
            $table->foreign('line_code')->references('code')->on('lines');
            $table->date("departure_date");
            $table->time("departure_time");
            $table->time("arrival_time");
            $table->integer("seats_booked");
            $table->integer("seats_available");
            $table->string("status");
            $table->string("cancellation_reason")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departures');
    }
};

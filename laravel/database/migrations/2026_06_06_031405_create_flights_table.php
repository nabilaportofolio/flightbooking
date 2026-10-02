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
    Schema::create('flights', function (Blueprint $table) {
        $table->uuid('flight_id')->primary();
        $table->uuid('airline_id');
        $table->string('flight_number');
        $table->string('origin_airport_id', 3);
        $table->string('destination_airport_id', 3);
        $table->dateTime('departure_time');
        $table->dateTime('arrival_time');
        $table->integer('duration_minutes');
        $table->enum('status', ['scheduled', 'delayed', 'cancelled', 'departed', 'landed']);
        $table->timestamps();

        $table->foreign('airline_id')->references('airline_id')->on('airlines');
        $table->foreign('origin_airport_id')->references('airport_id')->on('airports');
        $table->foreign('destination_airport_id')->references('airport_id')->on('airports');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};

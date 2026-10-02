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
    Schema::create('passengers', function (Blueprint $table) {
        $table->uuid('passenger_id')->primary();
        $table->uuid('booking_id');
        $table->string('full_name');
        $table->string('id_number');
        $table->enum('id_type', ['ktp', 'passport', 'sim']);
        $table->date('date_of_birth');
        $table->string('seat_number')->nullable();
        $table->timestamps();

        $table->foreign('booking_id')->references('booking_id')->on('bookings');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};

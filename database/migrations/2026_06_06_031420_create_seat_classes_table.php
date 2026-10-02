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
    Schema::create('seat_classes', function (Blueprint $table) {
        $table->uuid('seat_class_id')->primary();
        $table->uuid('flight_id');
        $table->enum('class_type', ['economy', 'business', 'first']);
        $table->integer('total_seats');
        $table->integer('available_seats');
        $table->decimal('price_idr', 15, 2);
        $table->timestamps();

        $table->foreign('flight_id')->references('flight_id')->on('flights');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_classes');
    }
};

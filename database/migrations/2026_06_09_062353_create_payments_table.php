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
    Schema::create('payments', function (Blueprint $table) {
        $table->uuid('payment_id')->primary();
        $table->uuid('booking_id');
        $table->enum('payment_method', ['transfer_bank', 'qris', 'kartu_kredit', 'virtual_account']);
        $table->decimal('amount_idr', 15, 2);
        $table->string('transaction_ref')->nullable();
        $table->timestamp('paid_at')->nullable();
        $table->enum('status', ['pending', 'success', 'failed', 'expired']);
        $table->timestamps();

        $table->foreign('booking_id')->references('booking_id')->on('bookings');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

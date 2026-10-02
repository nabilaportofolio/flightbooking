<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('booking_id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->string('booking_code')->unique();

            // Flight info
            $table->string('maskapai');
            $table->string('kode_penerbangan');
            $table->string('from');
            $table->string('to');
            $table->string('from_code', 10);
            $table->string('to_code', 10);
            $table->date('tanggal');
            $table->string('berangkat');
            $table->string('tiba');
            $table->string('durasi');
            $table->string('kelas');
            $table->integer('jumlah_penumpang')->default(1);

            // Harga
            $table->decimal('harga_tiket', 15, 2);
            $table->decimal('pajak', 15, 2)->default(50000);
            $table->decimal('biaya_layanan', 15, 2)->default(25000);
            $table->decimal('total_harga', 15, 2);

            // Kontak pemesan
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');

            // Status
            $table->enum('payment_status', ['pending', 'paid', 'cancelled', 'refunded'])
                  ->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('booked_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
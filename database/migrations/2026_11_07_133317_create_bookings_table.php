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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('booking_code')->unique();

        $table->foreignId('customer_id')
            ->constrained('customers')
            ->cascadeOnDelete();

        $table->foreignId('package_id')
            ->constrained('packages')
            ->restrictOnDelete();

        $table->date('tanggal_pemesanan');
        $table->string('hari', 20);
        $table->time('jam_pemesanan');
        $table->unsignedInteger('durasi');
        $table->string('layanan_tambahan')->nullable();
        $table->unsignedInteger('total_pembayaran');
        $table->string('metode_pembayaran');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

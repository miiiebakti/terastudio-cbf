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
    Schema::create('packages', function (Blueprint $table) {
        $table->id();
        $table->string('kategori_layanan');
        $table->string('nama_paket');
        $table->text('deskripsi')->nullable();
        $table->unsignedInteger('harga');
        $table->timestamps();

        $table->unique(
            ['kategori_layanan', 'nama_paket'],
            'unique_package'
        );
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

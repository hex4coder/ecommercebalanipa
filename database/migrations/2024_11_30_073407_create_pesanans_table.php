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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('tanggal');
            $table->enum('status', ['menunggu', 'sedang diproses', 'sudah dikirim', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->longText('alasan_pembatalan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

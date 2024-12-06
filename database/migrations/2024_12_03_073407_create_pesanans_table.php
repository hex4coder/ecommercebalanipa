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


            // product transactions
            // $table->string('booking_trx_id'); // BALA
            $table->dateTime('tanggal');
            $table->enum('status', ['baru', 'sedang diproses', 'sudah dikirim', 'selesai', 'dibatalkan'])->default('baru');
            $table->longText('alasan_pembatalan')->nullable();
            $table->unsignedBigInteger('total_harga_produk'); // total dari semua harga produk
            $table->unsignedBigInteger('total_diskon');
            $table->unsignedBigInteger('total_bayar');



            // pembayaran
            $table->text('bukti_transfer');
            $table->boolean('sudah_terbayar');
            $table->string('code_promo')->nullable(); // kode promo
            $table->foreignId('pelanggan_id')->constrained('pelanggan', 'id')->cascadeOnDelete()->cascadeOnUpdate();


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

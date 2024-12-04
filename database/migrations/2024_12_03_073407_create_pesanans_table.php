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
            $table->enum('status', ['menunggu', 'sedang diproses', 'sudah dikirim', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->longText('alasan_pembatalan')->nullable();
            $table->unsignedBigInteger('total_harga_produk'); // total dari semua harga produk
            $table->unsignedBigInteger('total_diskon');
            $table->unsignedBigInteger('total_bayar');

            // costumer info
            $table->string('nama');
            $table->string('email');
            $table->string('nomor_hp');
            $table->string('kota');
            $table->string('kode_pos');
            $table->text('alamat');

            // pembayaran
            $table->text('bukti_transfer');
            $table->boolean('sudah_terbayar');
            $table->foreignId('pelanggan_id')->constrained('pelanggan', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('promo_codes_id')->nullable()->constrained('promo_codes', 'id')->cascadeOnDelete()->cascadeOnUpdate();


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

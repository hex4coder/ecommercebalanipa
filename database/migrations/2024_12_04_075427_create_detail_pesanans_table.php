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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('produk_id')->constrained('produk', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('ukuran'); // ukuran produk
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('jumlah')->min(1)->default(1);
            $table->unsignedBigInteger('total');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};

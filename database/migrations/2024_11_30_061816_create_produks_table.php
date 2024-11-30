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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama');
            $table->longText('deskripsi');
            $table->bigInteger('harga');
            $table->enum('ukuran', array('s', 'm', 'l', 'xl', 'xxl'));
            $table->string('warna');
            $table->string('bahan');
            $table->integer('qty');
            $table->longText('gambar');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};

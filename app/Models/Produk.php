<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produk';
    protected $guarded = ['id'];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function detail_pesanan() {
        return $this->hasMany(DetailPesanan::class);
    }

    public function foto_produk() {
        return $this->hasMany(FotoProduk::class);
    }

    public function ukuran_produk() {
        return $this->hasMany(UkuranProduk::class);
    }

    public function ukuran() {
        return $this->ukuran_produk()->pluck('ukuran')->join(", ");
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class);
    }

    public function short_desc() {
        return Str::substr($this->deskripsi, 0, 100) . '...';
    }
}

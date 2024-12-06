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
    protected $guarded = [];

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function detail_pesanan() {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }

    public function foto_produk() {
        return $this->hasMany(FotoProduk::class, 'produk_id');
    }

    public function ukuran_produk() {
        return $this->hasMany(UkuranProduk::class, 'produk_id');
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id');
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }

    public function short_desc() {
        return Str::substr($this->deskripsi, 0, 100) . '...';
    }
}

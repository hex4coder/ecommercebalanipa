<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $guarded = [];

    public function pesanan() {
        return $this->belongsTo(Pesanan::class, 'id');
    }

    public function produk() {
        return $this->belongsTo(Produk::class, 'id');
    }
}

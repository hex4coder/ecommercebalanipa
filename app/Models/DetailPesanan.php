<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPesanan extends Model
{

    use SoftDeletes;

    protected $table = 'detail_pesanan';
    protected $guarded = [];

    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    }

    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}

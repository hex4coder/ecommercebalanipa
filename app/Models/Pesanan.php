<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $guarded = [];


    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id');
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{

    use SoftDeletes;

    protected $table = 'pesanan';
    protected $guarded = [];


    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id');
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}

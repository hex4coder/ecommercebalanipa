<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UkuranProduk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'produk_id', 'ukuran'
    ];


    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}

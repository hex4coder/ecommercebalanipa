<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FotoProduk extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'produk_id',
        'foto'
    ];

    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}

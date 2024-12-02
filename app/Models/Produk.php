<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produk';
    protected $guarded = [];

    public function brands() {
        return $this->belongsTo(Brand::class);
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id');
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }
}

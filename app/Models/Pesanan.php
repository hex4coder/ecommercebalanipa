<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{

    use SoftDeletes;

    protected $table = 'pesanan';
    protected $guarded = [];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}

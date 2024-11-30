<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use SoftDeletes;

    protected $table = 'pelanggan';

    protected $guarded = [];

    public function pesanan() {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }
}

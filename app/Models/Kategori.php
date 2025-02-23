<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;
    //
    protected $table = 'kategori';
    protected $guarded = [];


    public function produk() {
        return $this->hasMany(Produk::class);
    }
}

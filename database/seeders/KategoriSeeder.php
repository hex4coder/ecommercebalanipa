<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $listKategori = [
            'Celana Pria',
            'Celana Wanita',
            'Baju Pria',
            'Baju Wanita',
            'Celana Anak Laki-Laki',
            'Celana Anak Perempuan',
            'Aksesoris',
        ];

        foreach ($listKategori as $kat) {
            $k = new Kategori();
            $k->nama_kategori = $kat;
            $k->slug = Str::slug($kat);
            $k->save();
        }
    }
}

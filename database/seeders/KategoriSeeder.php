<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            $k->save();
        }
    }
}

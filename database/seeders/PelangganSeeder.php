<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p = new Pelanggan();
        $p->email = 'customer@test.com';
        $p->nama = 'Test Customer';
        $p->alamat = 'Mambu';
        $p->nomor_hp = '08232329323';
        $p->save();
    }
}

<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p = new PromoCode();
        $p->type = 'fixed';
        $p->code = 'fifty';
        $p->discount  = 50000;
        $p->save();


        $p2 = new PromoCode();
        $p2->type = 'percent';
        $p2->code = 'duabelas';
        $p2->discount  = 12; // 12 persen
        $p2->save();
    }
}

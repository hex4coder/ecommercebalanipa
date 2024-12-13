<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Kategori', Kategori::all()->count()),
            Stat::make('Brand', Brand::all()->count()),
            Stat::make('Produk', Produk::all()->count()),
            Stat::make('Customer', User::where('role', 0)->count()),
            Stat::make('Transaksi Produk', Pesanan::all()->count()),
        ];
    }
}

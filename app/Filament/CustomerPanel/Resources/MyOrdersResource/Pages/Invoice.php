<?php

namespace App\Filament\CustomerPanel\Resources\MyOrdersResource\Pages;

use App\Filament\CustomerPanel\Resources\MyOrdersResource;
use App\Models\Pesanan;
use App\Models\Produk;
use Filament\Resources\Pages\Page;

class Invoice extends Page
{
    protected static string $resource = MyOrdersResource::class;

    protected static string $view = 'filament.customer-panel.resources.my-orders-resource.pages.invoice';

    public Pesanan $order;

    public function mount() {
        $orderId = (request('record'));
        $this->order = Pesanan::with(['detail', 'detail.produk', 'user'])->where('id',$orderId)->first();
        // dd($this->order);
    }

    public function get_product_info($productId) {
        $product = Produk::find($productId);
        return $product->nama;
    }
}

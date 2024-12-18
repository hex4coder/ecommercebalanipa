<?php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use App\Models\Pesanan;
use App\Models\Produk;
use Filament\Resources\Pages\Page;

class InvoiceCustomer extends Page
{
    protected static string $resource = PesananResource::class;

    protected static string $view = 'filament.resources.pesanan-resource.pages.invoice-customer';

    public Pesanan $order;

    public function mount()
    {
        $orderId = (request('record'));
        $this->order = Pesanan::query()->with(['detail', 'detail.produk', 'user'])->where('id', $orderId)->first();
    }

    public function get_product_info($productId)
    {
        $product = Produk::find($productId);
        return $product->nama;
    }
}

<?php

namespace App\Livewire;

use App\Models\Produk;
use Livewire\Attributes\Url;
use Livewire\Component;

class Products extends Component
{
    private $products;

    #[Url]
    public $selectedCategories = [];

    #[Url]
    public $selectedBrand = [];

    public function mount()
    {
        $this->products = Produk::query()
        ->get();


        if($this->selectedBrand) {
            $this->products  = $this->products->whereIn('brand_id', $this->selectedBrand);
        }

        if($this->selectedCategories) {
            $this->products = $this->products->whereIn('kategori_id', $this->selectedCategories);
        }
    }

    public function render()
    {
        return view(
            'livewire.products',
            ['products' => $this->products]
        );
    }
}

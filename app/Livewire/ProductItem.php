<?php

namespace App\Livewire;

use App\Helpers\CartHelper;
use Livewire\Attributes\Url;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ProductItem extends Component
{

    use LivewireAlert;

    public $product;

    public function render()
    {
        return view('livewire.product-item');
    }

    public function AddToCart() {
        CartHelper::add($this->product->id,$this->product->nama,$this->product->harga);
        $this->dispatch('cart-updated');
        $this->alert('success', 'Produk telah ditambahkan ke keranjang belanja.', [
            'toast' => true,
            'position' => 'bottom-end',
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Helpers\CartHelper;
// use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class KeranjangBelanja extends Component
{


    public $items = [];
    public $totalBiaya = 0;


    #[On('cart-updated')]
    public function mount() {
        $this->items = CartHelper::getCart();
        $this->totalBiaya = CartHelper::getTotal();
    }


    public function render()
    {
        return view('livewire.keranjang-belanja');
    }


    public function AddQty($id) {
        CartHelper::increment($id);
        $this->dispatch('cart-updated');

    }
    public function DecQty($id) {
        CartHelper::decrement($id);
        $this->dispatch('cart-updated');
    }
}

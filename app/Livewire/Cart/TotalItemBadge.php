<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Helpers\CartHelper;
use Livewire\Attributes\On;

class TotalItemBadge extends Component
{
    public $cartTotalItem = 0;

    public function mount() {
        $this->cartTotalItem = CartHelper::getTotalItem();
    }

    #[On('cart-updated')]
    public function refreshCartTotalItem() {
        $this->cartTotalItem = CartHelper::getTotalItem();
    }

    public function render()
    {
        return view('livewire.cart.total-item-badge');
    }
}

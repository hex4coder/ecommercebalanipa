<?php

namespace App\Livewire;

use App\Helpers\CartHelper;
use Livewire\Attributes\On;
use Livewire\Component;

class Checkout extends Component
{

    public $cartItems = [];

    #[On('cart-updated')]
    public function mount() {
        $this->cartItems = CartHelper::getCart();
    }

    public function render()
    {
        return view('livewire.checkout');
    }

    public function GetImageUrl($id) {
        return CartHelper::getImageUrl($id);
    }

    public function GetTotal() {
        return CartHelper::getTotal();
    }
}

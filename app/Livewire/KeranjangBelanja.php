<?php

namespace App\Livewire;

use App\Helpers\CartHelper;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class KeranjangBelanja extends Component
{
    use LivewireAlert;

    public $items = [];
    public $totalBiaya = 0;

    public function getListeners()
    {
        return [
            'confirmed'
        ];
    }

    #[On('cart-updated')]
    public function mount()
    {
        $this->items = CartHelper::getCart();
        $this->totalBiaya = CartHelper::getTotal();
    }


    public function render()
    {
        return view('livewire.keranjang-belanja');
    }


    public function AddQty($id)
    {
        CartHelper::increment($id);
        $this->dispatch('cart-updated');
    }
    public function DecQty($id)
    {
        CartHelper::decrement($id);
        $this->dispatch('cart-updated');
    }


    public function ClearCart()
    {
        $this->confirm('Kosongkan keranjang belanja?', [
            'onConfirmed' => 'confirmed',
            'cancelButtonText' => 'Tidak',
            'confirmButtonText' => 'Ya',
            'confirmButtonColor' => 'red',
            'cancelButtonColor' => 'blue',
        ]);
    }

    public function confirmed()
    {
        CartHelper::clearCart();
        $this->dispatch('cart-updated');
        $this->alert('success', 'Keranjang dikosongkan.');
    }
}

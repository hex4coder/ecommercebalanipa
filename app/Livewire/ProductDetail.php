<?php

namespace App\Livewire;

use App\Helpers\CartHelper;
use App\Models\FotoProduk;
use App\Models\Produk;
use Livewire\Attributes\Url;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class ProductDetail extends Component
{
    use LivewireAlert;


    #[Url]
    public $id;

    public $product;
    public $currentImage;

    public function mount() {
        $this->product = Produk::query()->where('id', $this->id)->with(['foto_produk', 'ukuran_produk'])->first();
        $this->currentImage = $this->product->thumbnail;
    }


    public function render()
    {
        return view('livewire.product-detail');
    }

    public function AddToCart() {
        CartHelper::add($this->product->id,$this->product->nama,$this->product->harga);
        $this->dispatch('cart-updated');
        $this->alert('success', 'Produk telah ditambahkan ke keranjang belanja.', [
            'toast' => true,
            'position' => 'bottom-end',
        ]);
    }


    //TODO: ganti image pada thumbnail
    public function ChangeCurrentImage($imageId) {
        $newImage = FotoProduk::find($imageId);
        if($newImage) {
            $this->currentImage = $newImage->foto;
        }
    }
}

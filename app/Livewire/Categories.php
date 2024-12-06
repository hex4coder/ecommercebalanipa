<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Component;

class Categories extends Component
{
    public function render()
    {

        $kategori  = Kategori::all();

        return view('livewire.categories', [
            'kategori' => $kategori,
        ]);
    }
}

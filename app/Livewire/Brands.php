<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class Brands extends Component
{
    public function render()
    {

        $brands = Brand::all();

        return view('livewire.brands', [
            'brands' => $brands,
        ]);
    }
}

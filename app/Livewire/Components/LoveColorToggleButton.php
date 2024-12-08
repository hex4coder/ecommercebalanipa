<?php

namespace App\Livewire\Components;

use Livewire\Component;

class LoveColorToggleButton extends Component
{
    public $is_popular = false;
    public function render()
    {
        return view('livewire.components.love-color-toggle-button');
    }
}

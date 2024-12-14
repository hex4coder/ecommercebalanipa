<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{


    public $email = '';
    public $password = '';
    public $passwordConfirm = '';
    // TODO: Membuat register user / costumer


    public function render()
    {
        return view('livewire.auth.register');
    }


    public function register() {
        // registrasi user
    }
}

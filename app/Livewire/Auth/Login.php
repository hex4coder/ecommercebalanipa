<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;


    public $email = '';
    public $password = '';
    public $remember = true;


    protected $rules = [
        'password' => 'required|min:8',
        'email' => 'required|email',
    ];


    protected $messages = [
        '*.required' => 'Wajib diisi',
        '*.email' => 'Email tidak valid',
        'password.min' => 'Password minimal 8 karakter'
    ];


    public function render()
    {
        return view('livewire.auth.login');
    }



    public function login() {
        $credentials = $this->validate();
        // tahap login
        // 1. cek email
        $user = User::where('email', $this->email)->first();
        if($user) {
            // ada
            // 2. cek password
            if(Hash::check($this->password, $user->password)) {
                // user sudah login
                // 3. lakukan session dengan user object
                if(Auth::attempt($credentials)) {
                    // 4. masukkan dalam auth request
                    Auth::login($user, $this->remember);
                    session()->regenerate();
                    $this->alert('success', 'Login berhasil');
                    sleep(1);
                    return redirect()->intended('/');
                }
                // 5. redirect ke halaman /
            } else {
                // user tidak bisa login, password salah
                session()->flash('message', 'Password tidak benar!');
            }
        } else {
            session()->flash('message', 'Email anda belum terdaftar dalam sistem kami.');
            // tidak ada email
        }
    }
}

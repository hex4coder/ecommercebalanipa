<?php

namespace App\Livewire\Auth;

use App\Models\Address;
use App\Models\User;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Register extends Component implements HasForms
{


    use InteractsWithForms, LivewireAlert;


    // biodata customer
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // alamat lengkap customer
    public $nomorhp = '';
    public $provinsi = '';
    public $kota = '';
    public $kecamatan = '';
    public $desa = '';
    public $dusun = '';
    public $jalan = '';
    public $kodepos = '';

    // TODO: Membuat register user / costumer
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make("Biodata")
                    ->columns([
                        'default' => 1,
                        'xl' => 2,
                    ])
                    ->icon('heroicon-m-user')
                    ->completedIcon('heroicon-m-hand-thumb-up')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->label('Nama Lengkap')
                            ->prefixIcon('heroicon-o-user'),
                        TextInput::make('email')
                            ->unique('users', 'email')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                                'email' => 'Email tidak valid',
                                'unique' => 'Email ini sudah terdaftar',
                            ])
                            ->email()
                            ->prefixIcon('heroicon-o-envelope'),
                        TextInput::make('password')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                                'confirmed' => 'Konfirmasi password tidak cocok',
                            ])
                            ->password()
                            ->revealable()
                            ->prefixIcon('heroicon-o-lock-closed')->confirmed(),
                            TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->placeholder('Masukkan password yang sama')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->password()
                            ->revealable()
                            ->prefixIcon('heroicon-o-lock-closed')

                    ]),
                    Step::make("Alamat Anda")
                    ->columns([
                        'default' => 1,
                        'xl' => 2,
                    ])
                    ->icon('heroicon-m-home')
                    ->completedIcon('heroicon-m-hand-thumb-up')
                    ->schema([
                        TextInput::make('nomorhp')
                            ->prefixIcon('heroicon-o-phone')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                                'tel' => 'Nomor telepon tidak valid',
                                'numeric' => 'Nomor telepon tidak valid',
                            ])
                            ->label('Nomor HP')
                            ->tel()
                            ->numeric()
                            ->default('Nomor HP')
                            ->maxLength(255),
                        TextInput::make('provinsi')
                        ->prefixIcon('heroicon-o-home-modern')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->default('Sulawesi Barat')
                            ->maxLength(255),
                        TextInput::make('kota')
                        ->prefixIcon('heroicon-o-building-office-2')
                            ->label('Kota/Kabupaten')
                            ->default('Polewali Mandar')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->maxLength(255),
                        TextInput::make('kecamatan')
                        ->prefixIcon('heroicon-o-building-office')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->default('Luyo')
                            ->maxLength(255),
                        TextInput::make('desa')
                        ->prefixIcon('heroicon-o-building-library')
                            ->label('Desa/Kelurahan')
                            ->default('Mambu')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->maxLength(255),
                        TextInput::make('dusun')
                        ->prefixIcon('heroicon-o-globe-asia-australia')
                            ->label('Dusun/Lingkungan')
                            ->default('Kottar')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->maxLength(255),
                        TextInput::make('kodepos')
                        ->prefixIcon('heroicon-o-computer-desktop')
                            ->numeric()
                            ->default('91353')
                            ->minLength(5)
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->label('Kode POS')
                            ->maxLength(255),
                        Textarea::make('jalan')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->default('Jalan Poros Lena')
                            ->columnSpanFull()
                            ->maxLength(255),
                    ])
                ])

            ]);
    }


    public function render()
    {
        return view('livewire.auth.register');
    }

    protected function sendError($message) {
        session()->flash('error', $message);
    }


    public function register()
    {

        // registrasi user
        $data = $this->form->validate();


        if($data) {
            $u = new User();
            $u->name = $this->name;
            $u->email = $this->email;
            $u->password = bcrypt($this->password);
            $u->role = 1; // customer
            $u->email_verified_at = now('Asia/Makassar');
            if($u->save()) {
                $userID = $u->id;
                $addr = new Address();
                $addr->user_id = $userID;
                $addr->nomorhp = $this->nomorhp;
                $addr->provinsi = $this->provinsi;
                $addr->kota = $this->kota;
                $addr->kecamatan = $this->kecamatan;
                $addr->desa = $this->desa;
                $addr->dusun = $this->dusun;
                $addr->jalan = $this->jalan;
                $addr->kodepos = $this->kodepos;
                if($addr->save()) {
                    $this->alert('success', 'Registerasi user berhasil, silahkan login!');
                    sleep(1);
                    return redirect()->intended('/login');
                } else {
                    $this->sendError("Gagal membuat akun, kesalahan saat penginputan data alamat");
                }
            } else {
                $this->sendError("Gagal membuat akun, create user failed");
            }
        } else {
            $this->sendError('Lengkapi form dengan benar!');
        }
    }
}

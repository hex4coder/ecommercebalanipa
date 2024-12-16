<?php

namespace App\Filament\CustomerPanel\Pages;

use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;

class Profile extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.customer-panel.pages.profile';

    public $user;

    #[On('profile-updated')]
    public function mount()
    {
        $this->user = User::with(['address'])->where('id', Auth::user()->id)->first();
        if ($this->user != null) {
            $this->fillForm($this->user);
        }
    }

    protected function fillForm(User $user)
    {
        // bio user
        $this->name = $user->name;
        $this->email = $user->email;
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        // address info
        $this->nomorhp = $user->address->nomorhp;
        $this->provinsi = $user->address->provinsi;
        $this->kota = $user->address->kota;
        $this->kecamatan = $user->address->kecamatan;
        $this->desa = $user->address->desa;
        $this->dusun = $user->address->dusun;
        $this->jalan = $user->address->jalan;
        $this->kodepos = $user->address->kodepos;
    }

    // biodata customer
    public $name = '';
    public $email = '';
    public $current_password = '';
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
                Grid::make()->schema([
                    Section::make("Biodata")
                        ->columns([
                            'default' => 1,
                            'xl' => 2,
                        ])
                        ->icon('heroicon-m-user')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Wajib diisi',
                                ])
                                ->label('Nama Lengkap')
                                ->prefixIcon('heroicon-o-user'),
                            TextInput::make('email')
                                ->unique('users', 'email', ignoreRecord: true, ignorable: $this->user)
                                ->required()
                                ->validationMessages([
                                    'required' => 'Wajib diisi',
                                    'unique' => 'Email ini sudah terdaftar',
                                    'email' => 'Email tidak valid',
                                ])
                                ->disabled() // disable aja
                                ->email()
                                ->prefixIcon('heroicon-o-envelope'),
                            TextInput::make('current_password')
                                ->label('Password Lama')
                                ->autocomplete(false)
                                ->default('')
                                ->password()
                                ->revealable()
                                ->prefixIcon('heroicon-o-lock-closed'),
                            TextInput::make('password')
                                ->placeholder("Isi jika ingin mengganti password anda")
                                ->validationMessages([
                                    'confirmed' => 'Konfirmasi password tidak cocok',
                                    'min_length' => 'Panjang password minimal 8 karakter',
                                ])
                                ->minLength(8)
                                ->password()
                                ->revealable()
                                ->prefixIcon('heroicon-o-lock-closed')->confirmed(),
                            TextInput::make('password_confirmation')
                                ->label('Konfirmasi Password')
                                ->placeholder('Masukkan password yang sama')
                                ->password()
                                ->revealable()
                                ->prefixIcon('heroicon-o-lock-closed')

                        ]),
                    Section::make("Alamat Anda")
                        ->columns([
                            'default' => 1,
                            'xl' => 2,
                        ])
                        ->icon('heroicon-m-home')
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

    protected function send_error($message)
    {
        session()->flash('error', $message);
    }

    public function submit()
    {
        // dd($this->form->validate(), $this->form->getState());
        if ($this->form->validate()) {



            // update bio
            $this->user->name = $this->name;

            // jika password diisi
            if ($this->password != '') {
                if ($this->current_password == '') {
                    $this->send_error('Masukkan dulu password lama anda!');
                    return;
                } else {
                    // check password didatabase
                    if (!Hash::check($this->current_password, $this->user->password)) {
                        $this->send_error("Password lama anda tidak benar.");
                        return;
                    } else {
                        // jika password cocok
                        // validasi konfirmasi password
                        if ($this->password != $this->password_confirmation) {
                            $this->send_error("Password dan konfirmasi password salah.");
                            return;
                        } else {
                            // update password didatabase
                            $this->user->password = bcrypt($this->password);
                        }
                    }
                }
            }


            $this->user->save();

            // update address
            $this->user->address->nomorhp = $this->nomorhp;
            $this->user->address->provinsi = $this->provinsi;
            $this->user->address->kota = $this->kota;
            $this->user->address->kecamatan = $this->kecamatan;
            $this->user->address->desa = $this->desa;
            $this->user->address->dusun = $this->dusun;
            $this->user->address->jalan = $this->jalan;
            $this->user->address->kodepos = $this->kodepos;
            $this->user->address->save();
            $this->dispatch('profile-updated');
            Notification::make('success')->success()->title('Data berhasil disimpan')->send();
        } else {
        }
    }
}

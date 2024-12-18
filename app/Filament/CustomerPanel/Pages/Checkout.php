<?php

namespace App\Filament\CustomerPanel\Pages;

use App\Helpers\CartHelper;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\PromoCode;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;





class Checkout extends Page implements HasForms
{
    use InteractsWithForms;
    use LivewireAlert;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.customer-panel.pages.checkout';

    public $code = ''; // kode promo

    public $acc = false;

    public $cartItems = [];

    public User $customer;

    public $data = [];

    public Pesanan $order;

    protected function fillForm(User $user)
    {
        // bio user
        $this->data['name'] = $user->name;
        $this->data['email'] = $user->email;

        // address info
        $this->data['nomorhp'] = $user->address->nomorhp;
        $this->data['provinsi'] = $user->address->provinsi;
        $this->data['kota'] = $user->address->kota;
        $this->data['kecamatan'] = $user->address->kecamatan;
        $this->data['desa'] = $user->address->desa;
        $this->data['dusun'] = $user->address->dusun;
        $this->data['jalan'] = $user->address->jalan;
        $this->data['kodepos'] = $user->address->kodepos;
    }


    #[On('cart-updated')]
    public function mount()
    {

        $this->customer = User::find(Auth::user()->id);
        $this->fillForm($this->customer);
        $this->data['full_address'] = $this->customer->full_address();
        $this->cartItems  = CartHelper::getCart();

        // (count($this->cartItems));

        $details = [];
        $index = 0;
        foreach ($this->cartItems as $item) {
            // cari produk
            $produk  = Produk::with(['ukuran_produk'])->where('id', $item['id'])->first();

            // buat detail pesanan
            $detail = [];
            $detail['product_id'] = $produk->id;
            $detail['name'] = $item['name'];
            $detail['harga'] = $item['price'];
            $detail['jumlah'] = $item['quantity'];
            $detail['total'] = $item['price'] * $item['quantity'];
            $detail['ukuran'] = $produk->ukuran_produk[0]->ukuran;
            $detail['keterangan'] = '';
            $detail['image'] = CartHelper::getImageUrl($item['id']);


            $details[$index] = $detail;

            $index++;
        }
        $this->data['detail'] = $details;

        // pembayaran,
        $this->data['sudah_terbayar'] =  false; //belum
        $this->data['bukti_transfer'] = null;
        $this->data['total_harga_produk'] = CartHelper::getTotal();

        if ($this->code == '') {
            $this->data['total_diskon'] = 0;
            $this->data['total_bayar'] = $this->data['total_harga_produk'] - $this->data['total_diskon'];
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Step::make("Biodata")
                    ->description("Identitas anda")
                    ->icon("heroicon-m-user")
                    ->disabled()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->prefixIcon('heroicon-o-user'),
                        TextInput::make('email')
                            ->prefixIcon('heroicon-o-envelope'),
                        TextInput::make('nomorhp')
                            ->prefixIcon('heroicon-o-phone')
                            ->label('Nomor HP'),
                    ]),

                Step::make("Alamat Lengkap")
                    ->description("Hindari kesalahan pengiriman.")
                    ->icon('heroicon-m-home')
                    ->disabled()
                    ->schema([
                        Section::make()->schema([
                            Textarea::make('full_address')->label("Alamat Lengkap")
                                ->registerActions([
                                    Action::make('update')
                                        ->label("Update Profil")
                                        ->url(route('filament.customer.pages.profile'))
                                ]),
                        ])->footerActions([
                            Action::make('update-profil')->label('Update Profil')
                                ->icon('heroicon-o-pencil')
                                ->url(route('filament.customer.pages.profile'))

                        ])
                    ]),
                Step::make("Pembayaran")
                    ->description("Tuntaskan pesanan anda!")
                    ->icon('heroicon-m-credit-card')
                    ->columns([
                        'default' => 1,
                        'lg' => 2,
                    ])
                    ->schema([
                        Grid::make()->schema([
                            Section::make('Pembayaran')->schema([
                                FileUpload::make('bukti_transfer')
                                    ->label("Upload Bukti Pembayaran")
                                    ->image()
                                    ->directory('pesanan')
                                    ->imageEditor()
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Bukti transfer wajib dikirim.'
                                    ])
                            ])
                        ])->columns([
                            'default' => 1,
                            'lg' => 2,
                        ])
                    ]),

            ])->startOnStep(3),
        ])->statePath('data')->model(Pesanan::class);
    }

    // cek kode promo dan kurangi total belanjaan jika ada kode tersebut
    public function checkCode()
    {

        if ($this->code != '') {

            $code = PromoCode::where('code', $this->code)->first();
            if ($code == null) {
                session()->flash('code_error', 'Kode promo tidak valid');

                $this->data['total_diskon'] = 0;
                $this->data['total_bayar'] = $this->data['total_harga_produk'] - $this->data['total_diskon'];

                return;
            }

            // buat total discount
            $thp = $this->data['total_harga_produk'];
            $discount = $code->discount;
            if ($code->type == 'percent') {
                $discount = ($code->discount / 100) * $thp;
            }

            $this->data['total_diskon'] = $discount;
            $this->data['total_bayar'] = $this->data['total_harga_produk'] - $this->data['total_diskon'];


            session()->flash('code_success', 'Yay! Anda mendapatkan diskon');
        }
    }


    // tombol checkout pesanan
    public function checkout()
    {

        // validasi form
        $this->form->validate();

        // setujui data benar
        if ($this->acc == false) {
            session()->flash('error', 'Anda harus menyetujui jika anda telah mengecek data dengan benar.');
            return;
        }

        // buat order data
        // dd($this->data);
        $order = new Pesanan();
        $order->tanggal  = now();
        $order->user_id = $this->customer->id;
        $order->status = 'baru';
        $order->sudah_terbayar =  false;

        $upload_key = array_keys($this->data['bukti_transfer']);

        // file upload
        $uploaded_temp_file = ($this->data['bukti_transfer'])[$upload_key[0]];
        $bukti = $uploaded_temp_file->storePublicly();
        $order->bukti_transfer = $bukti;

        if ($this->code != '' && session()->has('code_success')) {
            $order->code_promo = $this->code;
        }
        $order->total_harga_produk = $this->data['total_harga_produk'];
        $order->total_diskon = $this->data['total_diskon'];
        $order->total_bayar = $this->data['total_bayar'];
        $order->save(); // untuk membuat ID

        // buat detail pesanan
        foreach ($this->data['detail'] as $detailOrder) {
            $do = new DetailPesanan();
            $do->pesanan_id = $order->id;
            $do->produk_id = $detailOrder['product_id'];
            $do->ukuran = $detailOrder['ukuran'];
            $do->keterangan = $detailOrder['keterangan'];
            $do->harga = $detailOrder['harga'];
            $do->jumlah = $detailOrder['jumlah'];
            $do->total = $detailOrder['total'];
            $do->save();
        }

        $this->alert('success', 'Pesanan berhasil dibuat.');

        // kosongkan cart
        CartHelper::clearCart();

        sleep(1);

        // redirect ke halaman pesanan
        return redirect(route('filament.customer.resources.pesanan-saya.index'));
    }
}

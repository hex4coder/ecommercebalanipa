<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Penjualan';

    protected static ?string $slug = 'pesanan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Order')
                        ->icon('heroicon-m-shopping-bag')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->columns([
                            'default' => 1,
                            'xl' => 2,
                        ])
                        ->afterValidation(
                            function ($state, callable $get, callable $set) {
                                $total = 0;
                                $details = $get('detail');
                                if ($details) {
                                    foreach ($details as $key => $value) {
                                        $detail = $value;
                                        if ($detail) {
                                            $total += $detail['total'];
                                        }
                                    }
                                    $set('total_harga_produk', $total);
                                    $set('total_bayar', $total);
                                }
                            }
                        )
                        ->schema([

                            Forms\Components\DateTimePicker::make('tanggal')
                                ->label('Tanggal Order')
                                ->required()
                                ->default(now())
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ]),
                            Select::make('status')
                                ->options([
                                    'menunggu' => 'Menunggu',
                                    'sedang diproses' => 'Sedang Diproses',
                                    'sudah dikirim' => 'Sudah Dikirim',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan',
                                ])
                                ->label('Status Pesanan')
                                ->required()
                                ->default('menunggu')
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ]),
                            Forms\Components\Textarea::make('alasan_pembatalan')
                                ->label('Alasan Pembatalan')->columnSpanFull(),
                            Repeater::make('detail')
                                ->label('Daftar Produk yang dipilih')
                                ->relationship()
                                ->columns([
                                    'default' => 1,
                                    'xl' => 2,
                                ])
                                ->schema([
                                    Select::make('produk_id')
                                        ->relationship('produk', 'nama')
                                        ->label('Produk')
                                        ->searchable()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $produk = Produk::find($state);
                                            if ($produk) {
                                                $set('harga', $produk->harga);
                                                $qty = $get('jumlah') ?? 1;
                                                if ($qty == 1) {
                                                    $set('jumlah', $qty);
                                                }
                                                $harga = $produk->harga;
                                                $total = $harga * $qty;
                                                $set('total', $total);
                                            } else {
                                                $set('keterangan', '');
                                                $set('ukuran', '');
                                                $set('harga', '');
                                                $set('jumlah', '');
                                                $set('total', '');
                                            }
                                        })
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                        ]),
                                    Select::make('ukuran') //TODO: Buat otomatis dari size produk
                                        ->options([
                                            's' => 'S',
                                            'm' => 'M',
                                            'l' => 'L',
                                            'xl' => 'XL',
                                            'xxl' => 'XXL',
                                            'xxxl' => 'XXXL',
                                        ])
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                        ])
                                        ->required(),
                                    TextInput::make('harga')->prefix('Rp. ')
                                        ->required()
                                        ->numeric()
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                            'numeric' => 'Harus angka!'
                                        ]),
                                    TextInput::make('jumlah') // TODO: Buat otomatis sesuai stok produk
                                        ->live()
                                        ->afterStateHydrated(
                                            function ($state, callable $get, callable $set) {
                                                $productId = $get('produk_id') ?? 0;
                                                $produk = Produk::find($productId);

                                                if ($produk) {
                                                    return $produk->stok;
                                                }
                                            }
                                        )
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $harga = $get('harga');
                                            if ($harga) {
                                                $qty = $state ?? 1;
                                                $total = $harga * $qty;
                                                $set('total', $total);
                                            }
                                        })
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(
                                            2
                                        )
                                        ->required()
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                            'numeric' => 'Harus angka!',
                                            'min.numeric' => 'Jumlah tidak valid',
                                            'max.numeric' => 'Jumlah tidak valid',
                                        ]),
                                    TextInput::make('total')->numeric()->required()->readOnly()->prefix('Rp. ')
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                            'numeric' => 'Harus angka!'
                                        ]),
                                    TextInput::make('keterangan')->placeholder('Boleh dikosongkan.'),
                                ])->columnSpanFull(),
                        ]),

                    Forms\Components\Wizard\Step::make('Customer Info')
                        ->icon('heroicon-m-users')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->columns([
                            'default' => 1,
                            'xl' => 2,
                        ])
                        ->schema([
                            Forms\Components\Select::make('pelanggan_id')
                                ->searchable()
                                ->preload()
                                ->relationship('pelanggan', 'nama')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ])
                                ->live()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $customer = Pelanggan::find($state);

                                    if ($customer) {
                                        $set('email', $customer->email);
                                        $set('nama', $customer->nama);
                                        $set('nomor_hp', $customer->nomor_hp);
                                        $set('alamat', $customer->alamat);
                                    }
                                }),

                            TextInput::make('nama')->required()->readOnly()->validationMessages([
                                'required' => 'Wajib diisi'
                            ]),
                            TextInput::make('email')
                                ->email()
                                ->required()->readOnly()->validationMessages([
                                    'required' => 'Wajib diisi',
                                    'email' => 'Email tidak valid',
                                ]),

                            TextInput::make('nomor_hp')->label('Nomor HP')->required()->readOnly()
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ]),
                            TextInput::make('kota')->required()->label('Kota / Kabupaten')
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ])
                                ->default("Polewali Mandar"),
                            TextInput::make('kode_pos')->required()->numeric()->label('Kode POS')
                                ->minLength(5)
                                ->length(5)
                                ->maxLength(5)
                                ->default(91353)
                                ->validationMessages([
                                    'required' => 'Wajib diisi',
                                    'numeric' => 'Harus angka',
                                    'min_length' => 'Isi 5 digit kode pos',
                                    'max_length' => 'Isi 5 digit kode pos',
                                ]),
                            Forms\Components\Textarea::make('alamat')->label('Alamat Lengkap')
                                ->required()
                                ->minLength(5)
                                ->validationMessages([
                                    'required' => 'Wajib diisi',
                                    'min_length' => 'Alamat tidak lengkap',
                                ])

                        ]),

                    Forms\Components\Wizard\Step::make('Pembayaran')
                        ->icon('heroicon-m-shopping-bag')
                        ->completedIcon('heroicon-m-hand-thumb-up')

                        ->schema([
                            Forms\Components\Section::make('Harga')->description('Deskripsi harga produk')
                                ->columns([
                                    'default' => 1,
                                    'xl' => 2,
                                ])
                                ->schema([
                                    TextInput::make('total_harga_produk')->required()->numeric()
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                            'numeric' => 'Harus angka!',
                                        ])->readOnly()
                                        ->label("Total Harga Produk")
                                        ->prefix('Rp. ')
                                        ->helperText('Akan terisi total harga dari produk yang dibeli.')
                                        ->default(0),

                                    TextInput::make('code_promo')
                                        ->label('Kode Promo')
                                        ->live()
                                        ->beforeStateDehydrated(
                                            function ($state, callable $get, callable $set) {
                                                if ($state) {
                                                    $promo = PromoCode::where('code', $state)->first();
                                                    $total_harga_produk = $get('total_harga_produk') ?? 0;
                                                    if ($promo) {
                                                        $type = $promo->type;
                                                        $discount = $promo->discount;
                                                        $total_diskon = $discount;
                                                        if ($type == 'percent') {
                                                            $total_diskon = ($discount / 100) * $total_harga_produk;
                                                        }
                                                        $set('total_diskon', $total_diskon);
                                                        $total_diskon = $get('total_diskon') ?? 0;
                                                        $total_bayar = $total_harga_produk - $total_diskon;
                                                        $set('total_bayar', $total_bayar);
                                                    } else {
                                                        $set('total_diskon', 0);
                                                        $set('total_bayar', $total_harga_produk);
                                                    }
                                                }
                                            }
                                        )
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            if ($state) {
                                                $promo = PromoCode::where('code', $state)->first();
                                                $total_harga_produk = $get('total_harga_produk') ?? 0;
                                                if ($promo) {
                                                    $type = $promo->type;
                                                    $discount = $promo->discount;
                                                    $total_diskon = $discount;
                                                    if ($type == 'percent') {
                                                        $total_diskon = ($discount / 100) * $total_harga_produk;
                                                    }
                                                    $set('total_diskon', $total_diskon);
                                                    $total_diskon = $get('total_diskon') ?? 0;
                                                    $total_bayar = $total_harga_produk - $total_diskon;
                                                    $set('total_bayar', $total_bayar);
                                                } else {
                                                    $set('total_diskon', 0);
                                                    $set('total_bayar', $total_harga_produk);
                                                }
                                            }
                                        })->helperText('Masukkan kode promo jika ada'),

                                    TextInput::make('total_diskon')
                                        ->label('Total Diskon')
                                        ->required()->numeric()
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                            'numeric' => 'Harus angka!',
                                        ])->readOnly()
                                        ->prefix('Rp. ')
                                        ->helperText('Terisi dari total diskon yang didapat berdasarkan kode'),


                                    TextInput::make('total_bayar')->required()->numeric()
                                        ->validationMessages([
                                            'required' => 'Wajib diisi',
                                            'numeric' => 'Harus angka!',
                                        ])->readOnly()
                                        ->label('Total Pembayaran')
                                        ->prefix('Rp. ')
                                        ->helperText('Berisi total harga yang harus dibayar'),
                                ]),




                            Forms\Components\Section::make('Bukti Pembayaran')->description('Keterangan dan bukti pembayaran')
                                ->columns([
                                    'default' => 1,
                                    'xl' => 2,
                                ])
                                ->schema([
                                    ToggleButtons::make('sudah_terbayar')
                                        ->boolean('Ya', 'Belum')
                                        ->grouped()
                                        ->default(false)
                                        ->label('Apakah sudah terbayar?'),

                                    FileUpload::make('bukti_transfer')
                                        ->label('Bukti Pembayaran')
                                        ->required()->validationMessages([
                                            'required' => 'Wajib diisi',
                                        ]),

                                ]),
                        ]),
                ])->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail.produk.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->dateTime()
                    ->label('Tanggal Order')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'sedang diproses' => 'Sedang Diproses',
                    'sudah dikirim' => 'Sudah Dikirim',
                    'selesai' => 'Selesai',
                    'dibatalkan' => 'Dibatalkan',
                ])
                ->rules(['required'])
                ->selectablePlaceholder(false)
                ->beforeStateUpdated(function($record, $state) {
                    // dd($state);
                })
                ->afterStateUpdated(function ($record, $state) {
                    Notification::make()
                    ->title("Status transaksi berhasil diperbarui")
                    ->success()
                    ->send();
                })
                ,
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

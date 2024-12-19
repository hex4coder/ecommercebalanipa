<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\Pages\ImageViewModal;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\PromoCode;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
                                    $set('total_diskon', 0);

                                    $promoCode = $get('code_promo');
                                    if ($promoCode) {
                                        $promo = PromoCode::where('code', $promoCode)->first();
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
                                    'baru' => 'Baru',
                                    'sedang diproses' => 'Sedang Diproses',
                                    'sudah dikirim' => 'Sudah Dikirim',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan',
                                ])
                                ->live()
                                ->label('Status Pesanan')
                                ->required()
                                ->default('baru')
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ]),
                            Forms\Components\Textarea::make('alasan_pembatalan')
                                ->visible(fn(Get $get) => $get('status') == 'dibatalkan')
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
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
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
                                        ->default('xl')
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
                        ])
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->searchable()
                                ->relationship(
                                    'user',
                                    'name',
                                    modifyQueryUsing: fn(Builder $query) => $query->where('role', 1)->with(['address']),
                                )
                                ->label('Pelanggan')
                                ->preload()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Wajib diisi'
                                ])
                                ->live()
                                ->afterStateUpdated(function ($state, Set $set) {
                                    $set('full_address', '');
                                    $customer = User::find($state);

                                    if ($customer) {
                                        $set('full_address', $customer->full_address());
                                    }
                                }),


                            Forms\Components\Textarea::make('full_address')
                                ->formatStateUsing(fn() => $form->getOperation() != 'create' ? $form->getRecord()->user->full_address() : "")
                                ->label('Alamat Lengkap')
                                ->required()
                                ->rows(5)
                                ->disabled(),
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
                                        ->live()
                                        ->default(false)
                                        ->label('Apakah sudah terbayar?'),

                                    FileUpload::make('bukti_transfer')
                                        ->label('Bukti Pembayaran')
                                        ->visible(fn(Get $get) => $get('sudah_terbayar') == true)
                                        ->required(fn(Get $get) => $get('sudah_terbayar') == true)
                                        ->validationMessages([
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
                Tables\Columns\TextColumn::make('tanggal')
                    ->dateTime()
                    ->label('Tanggal Pemesanan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Customer/Pelanggan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->badge()
                    ->colors([
                        'primary' => static fn($state): bool => $state === 'sedang diproses',
                        'primary' => static fn($state): bool => $state === 'sudah dikirim',
                        'warning' => static fn($state): bool => $state === 'baru',
                        'success' => static fn($state): bool => $state === 'selesai',
                        'danger' => static fn($state): bool => $state === 'dibatalkan',
                    ])
                    ->icons([
                        'heroicon-o-cog' => static fn($state): bool => $state === 'sedang diproses',
                        'heroicon-o-truck' => static fn($state): bool => $state === 'sudah dikirim',
                        'heroicon-o-document-arrow-up' => static fn($state): bool => $state === 'baru',
                        'heroicon-o-check-badge' => static fn($state): bool => $state === 'selesai',
                        'heroicon-o-x-circle' => static fn($state): bool => $state === 'dibatalkan',
                    ]),
                Tables\Columns\TextColumn::make('alasan_pembatalan')
                    ->toggleable()
                    ->toggledHiddenByDefault(true),
                Tables\Columns\TextColumn::make('sudah_terbayar')
                    ->label('Verifikasi Pembayaran')
                    ->badge()
                    ->icons([
                        'heroicon-o-x-circle' => static fn($state): bool => $state === 0,
                        'heroicon-o-check-badge' => static fn($state): bool => $state === 1,
                    ])
                    ->colors([
                        'danger' => static fn($state): bool => $state === 0,
                        'success' => static fn($state): bool => $state === 1,
                    ])
                    ->formatStateUsing(fn($state) => $state ? 'Terverifikasi' : 'Belum Diverifikasi'),
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
                Tables\Filters\SelectFilter::make('pelanggan')
                    ->label('Pelanggan / Customer')
                    ->relationship(
                        'user',
                        'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('role', 1),
                    ),

                Tables\Filters\SelectFilter::make("status")
                    ->label('Status Pesanan')
                    ->options([
                        'baru',
                        'sedang diproses',
                        'sudah dikirim',
                        'selesai',
                        'dibatalkan'
                    ]),


                Tables\Filters\TernaryFilter::make('sudah_terbayar')
                    ->label('Verifikasi Pembayaran')
                    ->placeholder("Semua")
                    ->falseLabel("Belum diverifikasi")
                    ->trueLabel("Sudah diverifikasi")
                    ->queries(
                        true: fn(Builder $query) => $query->where('sudah_terbayar', 1),
                        false: fn(Builder $query) => $query->where('sudah_terbayar', 0)
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('bukti_transfer')
                        ->visible(fn(Pesanan $record) => $record->sudah_terbayar == 0 || $record->status == 'baru')
                        ->label("Lihat Bukti Transfer")
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->mountUsing(function(Form $form, Pesanan $record) {
                            $form->fill([
                                'bukti_transfer' => $record->bukti_transfer,
                            ]);
                        })
                        ->form([
                            FileUpload::make('bukti_transfer')->disabled(true)
                            ,
                        ])
                        ->slideOver()
                        ->modalSubmitAction(false)
                        ,
                    Tables\Actions\Action::make('verifikasi')
                        ->visible(fn(Pesanan $record) => $record->sudah_terbayar == false)
                        ->label("Verifikasi Pembayaran")
                        ->modalDescription('Pastikan anda telah melihat bukti pembayaran, lanjutkan dan proses pesanan?')
                        ->color('warning')
                        ->icon('heroicon-m-check-badge')
                        ->requiresConfirmation()
                        ->action(function (Pesanan $record): void {
                            $record->sudah_terbayar = 1;
                            $record->status = 'sedang diproses';
                            $record->save();
                            Notification::make('verified')
                                ->title('Pembayaran telah diverifikasi dan pesanan sedang diproses')
                                ->success()
                                ->send();
                        }),
                        Tables\Actions\Action::make('kirim')
                        ->visible(fn(Pesanan $record) => $record->status == 'sedang diproses')
                        ->label("Kirim Pesanan")
                        ->color('warning')
                        ->icon('heroicon-m-truck')
                        ->requiresConfirmation()
                        ->action(function (Pesanan $record): void {
                            $record->status = 'sudah dikirim';
                            $record->save();
                            Notification::make('verified')
                                ->title('Pesanan telah dikirim.')
                                ->success()
                                ->send();
                        }),

                        Tables\Actions\Action::make('selesai')
                        ->visible(fn(Pesanan $record) => $record->status == 'sudah dikirim')
                        ->label("Sudah Sampai")
                        ->color('success')
                        ->icon('heroicon-m-check')
                        ->requiresConfirmation()
                        ->action(function (Pesanan $record): void {
                            $record->status = 'selesai';
                            $record->save();
                            Notification::make('verified')
                                ->title('Pesanan telah selesai.')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('batalkan')
                        ->visible(fn(Pesanan $record) => $record->status == 'baru' && $record->sudah_terbayar == false)
                        ->label("Batalkan Pesanan")
                        ->form([
                            TextInput::make('alasan_pembatalan')->required()->minLength(10)
                                ->validationMessages([
                                    'required' => 'Wajib diisi',
                                    'min_length' => 'Tidak valid',
                                ])
                        ])
                        ->color('danger')
                        ->icon('heroicon-m-x-circle')
                        ->requiresConfirmation()
                        ->action(function (array $data, Pesanan $record): void {
                            $record->status = 'dibatalkan';
                            $record->alasan_pembatalan = $data['alasan_pembatalan'];
                            $record->save();
                            Notification::make('cancelled')
                                ->title('Pesanan berhasil dibatalkan')
                                ->danger()
                                ->send();
                        }),
                    Tables\Actions\Action::make('invoice')
                        ->label("Lihat Invoice")
                        ->icon('heroicon-o-document')
                        ->color('primary')
                        ->url(fn(Pesanan $record) => route('filament.admin.resources.pesanan.invoice', $record)),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            // 'create' => Pages\CreatePesanan::route('/create'),
            // 'edit' => Pages\EditPesanan::route('/{record}/edit'),
            'invoice' => Pages\InvoiceCustomer::route('/{record}/invoice'),
            // 'bukti-transfer' => Pages\ImageViewModal::route('/{record}/bukti-transfer'),
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

<?php

namespace App\Filament\CustomerPanel\Resources;

use App\Filament\CustomerPanel\Resources\MyOrdersResource\Pages;
use App\Models\Pesanan;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class MyOrdersResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $slug = 'pesanan-saya';
    protected static ?string $label = 'Pesanan Saya';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Pesanan::query()->where('user_id', Auth::user()->id))
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal Pemesanan')
                    ->dateTime()
                    ->formatStateUsing(fn($state) => $state),
                TextColumn::make('total_bayar')
                    ->label('Total Harga')
                    ->formatStateUsing(fn($state) => Number::currency($state, 'Rp.', 'ID')),
                TextColumn::make('status')
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
                TextColumn::make('sudah_terbayar')
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
                    ->formatStateUsing(fn($state) => $state ? 'Terverifikasi' : 'Belum Diverifikasi')
            ])
            ->filters([
                //
                SelectFilter::make("status")
                    ->label('Status Pesanan')
                    ->options([
                        'baru',
                        'sedang diproses',
                        'sudah dikirim',
                        'selesai',
                        'dibatalkan'
                    ]),


                TernaryFilter::make('sudah_terbayar')
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
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                ActionGroup::make([
                    Action::make('batalkan')
                        ->visible(fn(Pesanan $record) => $record->status != 'dibatalkan')
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
                        }),
                    Action::make('invoice')
                        ->label("Lihat Invoice")
                        ->icon('heroicon-o-document')
                        ->color('primary')
                        ->url(fn(Pesanan $record) => route('filament.customer.resources.pesanan-saya.invoice', $record)),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->emptyStateIcon('heroicon-o-shopping-cart')
            ->emptyStateHeading('Belum ada pesanan')
            ->emptyStateDescription("Silahkan belanja dulu, lalu lakukan checkout produk.")
            ->emptyStateActions([
                Action::make('buy')
                    ->label('Belanja Sekarang')
                    ->url(route('product.list'))
                    ->icon('heroicon-m-shopping-bag')
                    ->button(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyOrders::route('/'),
            'invoice' => Pages\Invoice::route('/{record}/invoice')
        ];
    }
}

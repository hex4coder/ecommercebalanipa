<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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
                Forms\Components\Select::make('pelanggan_id')
                    ->relationship('pelanggan', 'nama')
                    ->required(),
                Forms\Components\DateTimePicker::make('tanggal')
                    ->label('Tanggal Order')
                    ->required(),
                Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'sedang diproses' => 'Sedang Diproses',
                        'sudah dikirim' => 'Sudah Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->label('Status Pesanan')
                    ->required(),
                Repeater::make('detail')
                    ->relationship()
                    ->schema([
                        Select::make('produk_id')
                            ->relationship('produk', 'nama')
                            ->label('Produk')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $produk = Produk::find($state);
                                $set('harga', $produk->harga);

                                $qty = $get('jumlah');

                                if ($qty) {
                                    $harga = $produk->harga;
                                    $total = $harga * $qty;
                                    $set('total', $total);
                                }
                            })
                            ->required(),
                        TextInput::make('harga')->prefix('Rp. ')->disabled(),
                        TextInput::make('jumlah')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $harga = $get('harga');
                                $qty = $state ?? 0;
                                $total = $harga * $qty;
                                $set('total', $total);
                            })
                            ->numeric()
                            ->required(),
                        TextInput::make('total')->numeric()->required()->readOnly(),
                    ]),
                Forms\Components\Textarea::make('alasan_pembatalan')
                    ->label('Alasan Pembatalan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->dateTime()
                    ->label('Tanggal Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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

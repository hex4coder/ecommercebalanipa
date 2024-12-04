<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $slug = 'produk';
    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Produk")
                    ->columns([
                        'default' => 1,
                        'xl' => 2,
                    ])
                    ->description("Masukkan data dengan benar!")
                    ->schema([

                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->label('Nama Produk'),
                        Forms\Components\TextInput::make('harga')
                            ->prefix('Rp. ')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                            ])
                            ->numeric(),
                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->required()
                            ->validationMessages([
                                'required' => 'Wajib diisi',
                                'numeric' => 'Harus angka!'
                            ])
                            ->numeric(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->required(),
                    ]),

                Section::make("Informasi Tambahan")
                    ->columns([
                        'default' => 1,
                        'xl' => 2
                    ])
                    ->description('Masukan informasi tambahan dengan benar')->schema([
                        Forms\Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Merek')
                            ->required(),
                        Forms\Components\ToggleButtons::make('is_popular')
                        ->boolean('Populer', 'Tidak Populer')
                        ->grouped()
                        ->default(false)
                        ->label('Tandai sebagai produk populer?'),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->required()
                            ->label('Thumbnail / Foto'),
                    ]),

                Section::make("Size & Photos")
                    ->description("Tambahkan foto produk dan ukuran produk.")
                    ->columns([
                        'default' => 1,
                        'xl' => 2
                    ])
                    ->schema([
                        Repeater::make('foto_produk')
                            ->relationship()
                            ->schema([
                                FileUpload::make('foto')->required(),
                            ])->label('Foto Lainnya'),
                        Repeater::make('ukuran_produk')
                            ->relationship()
                            ->schema([
                                TextInput::make('ukuran')->required(),
                            ])->label('Ukuran Produk')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('Daftar produk hasil karya Teaching Factory di SMKN Balanipa')
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')->label('Merek'),
                Tables\Columns\TextColumn::make('harga')
                    ->prefix('Rp. ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ukuran_produk.ukuran')
                    ->label('Ukuran'),
                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori'),
                SelectFilter::make('brand_id')
                    ->label('Merek')
                    ->relationship('brand', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
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

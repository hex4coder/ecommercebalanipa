<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Filament\Resources\KategoriResource\RelationManagers;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data';
    // protected static ?string $navigationLabel = 'Kategori';
    protected static ?string $slug = 'kategori';
    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'default' => 1,
                'xl' => 2,
            ])
            ->schema([
                //
                TextInput::make('nama_kategori')
                ->required()
                ->unique('kategori', 'nama_kategori', ignoreRecord: true)
                ->label('Kategori')
                ->live(onBlur: true)
                ->afterStateUpdated(function($state, Set $set) {
                    if($state) {
                        $set('slug', Str::slug($state));
                    }
                })
                ->validationMessages([
                    'unique' => 'Kategori sudah ada'
                ]),


                TextInput::make('slug')
                ->required()
                ->disabled()
                ->dehydrated(false),



                FileUpload::make('gambar')
                ->label('Gambar')
                ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar'),
                TextColumn::make('nama_kategori')
                ->label('Nama Kategori')
                ->sortable()
                ->searchable(),
                TextColumn::make('slug')
                ->sortable()
                ,




            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
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

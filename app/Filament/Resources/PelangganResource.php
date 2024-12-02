<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Pengguna';

    protected static ?string $slug = 'pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique('pelanggan', 'email')
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                        'unique' => 'Email sudah ada',
                        'email' => 'Email tidak valid'
                    ])
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                    ])
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_hp')
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                        'min_digits' => 'Minimal 11 digit',
                        'max_digits' => 'Maximal 15 digits'
                    ])
                    ->numeric()
                    ->label('Nomor HP')
                    ->minLength(11)
                    ->maxLength(15),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->minLength(10)
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                        'min_digits' => 'Minimal 10 digit',
                    ])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('profil')
                    ->required()
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                ->copyable()
                ->copyMessage('Email berhasil disalin.')
                ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp')
                ->searchable(),
                Tables\Columns\ImageColumn::make('profil'),
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
                    RestoreBulkAction::make(),
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
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

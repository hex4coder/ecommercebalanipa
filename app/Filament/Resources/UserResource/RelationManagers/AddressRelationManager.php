<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Address;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';
    protected static ?string $modelLabel = 'Alamat Pengguna';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomorhp')
                    ->required()
                    ->label('Nomor HP')
                    ->tel()
                    ->numeric()
                    ->default('Nomor HP')
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                    ->required()
                    ->default('Sulawesi Barat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kota')
                    ->label('Kota/Kabupaten')
                    ->default('Polewali Mandar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->default('Luyo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('desa')
                    ->label('Desa/Kelurahan')
                    ->default('Mambu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dusun')
                    ->label('Dusun/Lingkungan')
                    ->default('Kottar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kodepos')
                    ->numeric()
                    ->default('91353')
                    ->minLength(5)
                    ->required()
                    ->label('Kode POS')
                    ->maxLength(255),
                Forms\Components\Textarea::make('jalan')
                    ->required()
                    ->default('Jalan Poros Lena')
                    ->columnSpanFull()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('provinsi')
            ->columns([
                Tables\Columns\TextColumn::make('nomorhp')->label('Nomor HP'),
                Tables\Columns\TextColumn::make('provinsi'),
                Tables\Columns\TextColumn::make('kota'),
                Tables\Columns\TextColumn::make('kecamatan'),
                Tables\Columns\TextColumn::make('desa'),
                Tables\Columns\TextColumn::make('dusun'),
                Tables\Columns\TextColumn::make('kodepos'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->hidden(function (RelationManager $livewire) {

                    $user = $livewire->getOwnerRecord();
                    return (Address::where('user_id', $user->id)->withTrashed()->count() == 0 ? null : true);
                }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}

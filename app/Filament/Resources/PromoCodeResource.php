<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Filament\Resources\PromoCodeResource\RelationManagers;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Kode Promo';
    protected static ?string $navigationGroup = 'Penjualan';
    protected static ?string $label = 'Kode Promo';

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'default' => 1,
                'xl' => 3,
            ])
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique('promo_codes', 'code')
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                        'unique' => 'Kode promo sudah ada'
                    ])
                    ->label('Kode Promo')
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                ->options([
                    'fixed' => 'Diskon Fix',
                    'percent' => 'Diskon Persentase'
                ])
                ->required()
                ->live()
                ->validationMessages([
                    'required' => 'Wajib diisi'
                ])
                ->label('Tipe Promo'),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Wajib diisi',
                        'numeric' => 'Harus angka!'
                    ])
                    ->label('Diskon')
                    ->prefix(fn(Get $get) => $get('type') === 'percent' ? null : 'Rp. ')
                    ->suffix(fn(Get $get) => $get('type') === 'percent' ? '%' : null)
                    ->default(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Promo')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->prefix(fn(PromoCode $record) => $record->type === 'percent' ? null : 'Rp. ')
                    ->suffix(fn(PromoCode $record) => $record->type === 'percent' ? '%' : null)
                    ->label('Diskon')
                    ->sortable(),
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}

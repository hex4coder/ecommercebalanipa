<?php

namespace App\Filament\CustomerPanel\Resources;

use App\Filament\CustomerPanel\Resources\MyOrdersResource\Pages;
use App\Filament\CustomerPanel\Resources\MyOrdersResource\RelationManagers;
use App\Models\MyOrders;
use App\Models\Pesanan;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
            ->columns([
                //
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
            'create' => Pages\CreateMyOrders::route('/create'),
            'view' => Pages\ViewMyOrders::route('/{record}'),
            'edit' => Pages\EditMyOrders::route('/{record}/edit'),
        ];
    }
}

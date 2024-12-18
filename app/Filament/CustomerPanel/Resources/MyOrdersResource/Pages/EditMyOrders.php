<?php

namespace App\Filament\CustomerPanel\Resources\MyOrdersResource\Pages;

use App\Filament\CustomerPanel\Resources\MyOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyOrders extends EditRecord
{
    protected static string $resource = MyOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

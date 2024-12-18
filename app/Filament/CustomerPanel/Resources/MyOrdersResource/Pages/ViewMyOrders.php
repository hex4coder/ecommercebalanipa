<?php

namespace App\Filament\CustomerPanel\Resources\MyOrdersResource\Pages;

use App\Filament\CustomerPanel\Resources\MyOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMyOrders extends ViewRecord
{
    protected static string $resource = MyOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

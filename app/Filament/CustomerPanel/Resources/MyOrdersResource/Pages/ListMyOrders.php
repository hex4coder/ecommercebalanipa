<?php

namespace App\Filament\CustomerPanel\Resources\MyOrdersResource\Pages;

use App\Filament\CustomerPanel\Resources\MyOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyOrders extends ListRecords
{
    protected static string $resource = MyOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

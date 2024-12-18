<?php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;

class ImageViewModal extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = PesananResource::class;

    protected static string $view = 'filament.resources.pesanan-resource.pages.image-view-modal';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        FileUpload::make('bukti_transfer')
                            ->src($this->record->bukti_transfer)
                            ->height(500) // Adjust the image height as needed
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\FileuploadResource\Pages;

use App\Filament\Resources\FileuploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFileuploads extends ListRecords
{
    protected static string $resource = FileuploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

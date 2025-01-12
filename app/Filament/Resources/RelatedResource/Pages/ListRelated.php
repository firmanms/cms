<?php

namespace App\Filament\Resources\RelatedResource\Pages;

use App\Filament\Resources\RelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRelated extends ListRecords
{
    protected static string $resource = RelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

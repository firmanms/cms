<?php

namespace App\Filament\Resources\RelatedResource\Pages;

use App\Filament\Resources\RelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRelated extends CreateRecord
{
    protected static string $resource = RelatedResource::class;
}

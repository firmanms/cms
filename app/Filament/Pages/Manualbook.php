<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Manualbook extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Manual Book';

    protected static ?string $modelLabel = 'Manual Book';

    protected static ?string $pluralLabel = 'Manual Book';

    protected static ?string $navigationGroup = 'Bantuan';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manualbook';
}

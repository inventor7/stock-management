<?php

namespace App\Filament\Resources\BonAcompteResource\Pages;

use App\Filament\Resources\BonAcompteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBonAcomptes extends ListRecords
{
    protected static string $resource = BonAcompteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\BonAcompteResource\Pages;

use App\Filament\Resources\BonAcompteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBonAcompte extends ViewRecord
{
    protected static string $resource = BonAcompteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifier'),
        ];
    }
}

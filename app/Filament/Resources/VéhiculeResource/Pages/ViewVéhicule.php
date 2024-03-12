<?php

namespace App\Filament\Resources\VéhiculeResource\Pages;

use App\Filament\Resources\VéhiculeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVéhicule extends ViewRecord
{
    protected static string $resource = VéhiculeResource::class;
    protected static ?string $title = 'Véhicule';
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifier'),
        ];
    }
}

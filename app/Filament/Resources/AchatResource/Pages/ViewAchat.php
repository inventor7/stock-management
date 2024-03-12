<?php

namespace App\Filament\Resources\AchatResource\Pages;

use App\Filament\Resources\AchatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAchat extends ViewRecord
{
    protected static string $resource = AchatResource::class;
    protected static ?string $title = 'Bon Achat';



    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifier'),
        ];
    }
}

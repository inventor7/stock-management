<?php

namespace App\Filament\Resources\BonAcompteResource\Pages;

use App\Filament\Resources\BonAcompteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBonAcompte extends EditRecord
{
    protected static string $resource = BonAcompteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\VéhiculeResource\Pages;

use App\Filament\Resources\VéhiculeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVéhicule extends EditRecord
{
    protected static string $resource = VéhiculeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

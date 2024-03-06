<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('créer une commande')
        ];
    }
}

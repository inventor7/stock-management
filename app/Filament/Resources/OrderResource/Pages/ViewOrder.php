<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Button;


class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Commande';


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifier'),
        ];
    }




}

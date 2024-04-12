<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Button;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OrderResource;
use App\Models\Order;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Commande';


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifier'),
            Action::make('download')
                ->label('Télécharger')
                ->icon('heroicon-o-document-arrow-down')
                ->openUrlInNewTab(true)
                ->url(fn (Order $record) => route('order.download', $record))

        ];
    }
}

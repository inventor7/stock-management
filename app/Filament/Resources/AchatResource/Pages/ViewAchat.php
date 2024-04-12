<?php

namespace App\Filament\Resources\AchatResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Filament\Resources\AchatResource;
use App\Models\Achat;
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
            Action::make('download')
                ->label('Télécharger')
                ->icon('heroicon-o-document-arrow-down')
                ->openUrlInNewTab(true)
                ->url(fn (Achat $record) => route('achat.download', $record))
        ];
    }
}

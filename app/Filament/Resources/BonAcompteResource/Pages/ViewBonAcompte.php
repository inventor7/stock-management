<?php

namespace App\Filament\Resources\BonAcompteResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\BonAcompteResource;
use App\Models\BonAcompte;
use Spatie\LaravelPdf\Facades\Pdf;

class ViewBonAcompte extends ViewRecord
{
    protected static string $resource = BonAcompteResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make()
                ->label('Modifier'),
            Action::make('download')
                ->label('Télécharger')
                ->icon('heroicon-o-document-arrow-down')
                ->openUrlInNewTab(true)
                ->url(fn (BonAcompte $record) => route('bonacompte.pdf', $record)),
        ];
    }
}

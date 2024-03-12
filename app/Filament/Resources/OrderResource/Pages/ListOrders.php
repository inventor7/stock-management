<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

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


    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('Tous')
                ->badge(Order::query()->count())
                ->icon('heroicon-o-rectangle-stack')
                ->iconPosition(IconPosition::After),
            'processing' => Tab::make()
                ->icon('heroicon-m-arrow-path')
                ->badge(Order::query()->where('status', 'processing')->count())
                ->iconPosition(IconPosition::After)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing')),
            'shipped' => Tab::make()
                ->icon('heroicon-m-truck')
                ->badge(Order::query()->where('status', 'shipped')->count())
                ->iconPosition(IconPosition::After)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'shipped')),
        ];
    }
}

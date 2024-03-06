<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case New = 'nouveaux';

    case Processing = 'en cours de fabrication';

    case Shipped = 'livrés';

    case Cancelled = 'annulés';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'Nouveaux',
            self::Processing => 'En cours de fabrication',
            self::Shipped => 'Livrés',
            self::Cancelled => 'Annulés',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::New => 'info',
            self::Processing => 'warning',
            self::Shipped => 'success',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-sparkles',
            self::Processing => 'heroicon-m-arrow-path',
            self::Shipped => 'heroicon-m-truck',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}

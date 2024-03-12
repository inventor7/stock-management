<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum VéhiculeStatus: string implements HasColor, HasIcon, HasLabel
{
    case enpanne = 'enpanne';

    case vidange = 'vidange';

    case controletechinique = 'controletechinique';

    case ok = 'ok';

    public function getLabel(): string
    {
        return match ($this) {
            self::enpanne => 'En panne',
            self::vidange => 'Alerte Vidange',
            self::controletechinique => 'Alerte Controle Technique',
            self::ok => 'OK',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::vidange, self::controletechinique => 'warning',
            self::ok => 'success',
            self::enpanne => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::vidange => 'heroicon-m-exclamation-triangle',
            self::controletechinique => 'heroicon-m-exclamation-triangle',
            self::ok => 'heroicon-m-check-circle',
            self::enpanne => 'heroicon-m-x-circle',
        };
    }
}

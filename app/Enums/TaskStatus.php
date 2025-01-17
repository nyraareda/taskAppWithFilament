<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TaskStatus: string implements HasColor, HasIcon
{
    case Pending = 'pending';
    case Completed = 'completed';

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Completed => 'success',
        };
    }


    public function getIcon(): string
    {
        return match ($this) {
            self::Pending => 'heroicon-o-clock',
            self::Completed => 'heroicon-o-check-circle',
        };
    }

}

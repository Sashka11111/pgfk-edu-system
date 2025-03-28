<?php

namespace Liamtseva\PGFKEduSystem\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Qualification: string implements HasLabel, HasColor, HasIcon
{
    case MASTER = 'master';         // Магістр
    case CANDIDATE = 'candidate';   // Кандидат наук
    case DOCTOR = 'doctor';         // Доктор наук
    case NONE = 'none';             // Без кваліфікації (для випадків, коли її ще немає)

    /**
     * Повертає мітку для Filament
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::MASTER => 'Магістр',
            self::CANDIDATE => 'Кандидат наук',
            self::DOCTOR => 'Доктор наук',
            self::NONE => 'Без кваліфікації',
        };
    }

    /**
     * Повертає колір для Filament
     */
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::MASTER => 'info',      // Синій у Filament
            self::CANDIDATE => 'success', // Зелений у Filament
            self::DOCTOR => 'warning',    // Жовтий у Filament
            self::NONE => 'gray',         // Сірий у Filament
        };
    }

    /**
     * Повертає іконку для Filament (опціонально)
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::MASTER => 'heroicon-o-academic-cap',
            self::CANDIDATE => 'heroicon-o-book-open',
            self::DOCTOR => 'heroicon-o-star',
            self::NONE => 'heroicon-o-minus-circle',
        };
    }
}

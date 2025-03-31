<?php

namespace Liamtseva\PGFKEduSystem\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel, HasColor, HasIcon
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    /**
     * Повертає мітку для Filament
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::MALE => 'Чоловік',
            self::FEMALE => 'Жінка',
            self::OTHER => 'Інше',
        };
    }

    /**
     * Повертає колір для Filament
     */
    public function getColor(): string
    {
        return match ($this) {
            self::MALE => 'info',    // Блакитний для чоловіків
            self::FEMALE => 'warning',  // Рожевий для жінок
            self::OTHER => 'gray',   // Сірий для інших
        };
    }

    /**
     * Повертає іконку для Filament.
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::MALE => 'fas-male',  // Іконка для чоловіків
            self::FEMALE => 'fas-female',       // Іконка для жінок
            self::OTHER => 'bx-male-female', // Іконка для інших
        };
    }
}

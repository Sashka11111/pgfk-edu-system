<?php

namespace Liamtseva\PGFKEduSystem\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Qualification: string implements HasLabel, HasColor, HasIcon
{
    case SPECIALIST = 'specialist';               // Спеціаліст
    case SECOND_CATEGORY = 'second_category';     // Спеціаліст другої категорії
    case FIRST_CATEGORY = 'first_category';       // Спеціаліст першої категорії
    case HIGHEST_CATEGORY = 'highest_category';   // Спеціаліст вищої категорії
    case NONE = 'none';                           // Без категорії

    /**
     * Повертає мітку для Filament
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::SPECIALIST => 'Спеціаліст',
            self::SECOND_CATEGORY => 'Спеціаліст другої категорії',
            self::FIRST_CATEGORY => 'Спеціаліст першої категорії',
            self::HIGHEST_CATEGORY => 'Спеціаліст вищої категорії',
            self::NONE => 'Без категорії',
        };
    }

    /**
     * Повертає колір для Filament
     */
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SPECIALIST => 'primary',      // Блакитний у Filament
            self::SECOND_CATEGORY => 'info',    // Синій у Filament
            self::FIRST_CATEGORY => 'success',  // Зелений у Filament
            self::HIGHEST_CATEGORY => 'warning', // Жовтий у Filament
            self::NONE => 'gray',               // Сірий у Filament
        };
    }

    /**
     * Повертає іконку для Filament
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::SPECIALIST => 'heroicon-o-user',
            self::SECOND_CATEGORY => 'heroicon-o-check-circle',
            self::FIRST_CATEGORY => 'heroicon-o-shield-check',
            self::HIGHEST_CATEGORY => 'heroicon-o-trophy',
            self::NONE => 'heroicon-o-minus-circle',
        };
    }
}

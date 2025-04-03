<?php

namespace Liamtseva\PGFKEduSystem\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StudyForm: string implements HasLabel, HasColor, HasIcon
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case DISTANCE = 'distance';

    /**
     * Повертає мітку для Filament
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::FULL_TIME => 'Очне',         // Очна форма навчання
            self::PART_TIME => 'Заочне',      // Заочна форма навчання
            self::DISTANCE => 'Дистанційне',  // Дистанційна форма навчання
        };
    }

    /**
     * Повертає колір для Filament
     */
    public function getColor(): string
    {
        return match ($this) {
            self::FULL_TIME => 'primary',   // Блакитний для очної форми
            self::PART_TIME => 'warning',   // Жовтий для заочної форми
            self::DISTANCE => 'info',      // Синій для дистанційної форми
        };
    }

    /**
     * Повертає іконку для Filament
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::FULL_TIME => 'heroicon-o-building-office', // Іконка для очної форми
            self::PART_TIME => 'heroicon-o-clock',           // Іконка для заочної форми
            self::DISTANCE => 'heroicon-o-globe-alt',        // Іконка для дистанційної форми
        };
    }
}

<?php

namespace Liamtseva\PGFKEduSystem\Enums;

use Filament\Support\Contracts\HasLabel;

enum Department: string implements HasLabel
{
    case PART_1 = 'department_part_1';
    case PART_2 = 'department_part_2';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PART_1 => 'Навчальна частина 1',
            self::PART_2 => 'Навчальна частина 2',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PART_1 => 'primary', // Блакитний у Filament
            self::PART_2 => 'secondary', // Сірий у Filament
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PART_1 => 'heroicon-o-book-open', // Іконка для навчальної частини 1
            self::PART_2 => 'heroicon-o-bookmark',  // Іконка для навчальної частини 2
        };
    }
}

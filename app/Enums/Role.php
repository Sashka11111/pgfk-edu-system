<?php

namespace Liamtseva\PGFKEduSystem\Enums;


enum Role: string //implements HasLabel, HasColor, HasIcon
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';

    /**
     * Повертає мітку для Filament
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::STUDENT => 'Студент',
            self::TEACHER => 'Викладач',
            self::ADMIN => 'Адміністратор',
        };
    }

    /**
     * Повертає колір для Filament
     */
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::STUDENT => 'primary',   // Блакитний у Filament
            self::TEACHER => 'success',   // Зелений у Filament
            self::ADMIN => 'danger',      // Червоний у Filament
        };
    }

    /**
     * Повертає іконку для Filament
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::STUDENT => 'heroicon-o-user',         // Іконка користувача
            self::TEACHER => 'heroicon-o-academic-cap', // Іконка викладача
            self::ADMIN => 'heroicon-o-shield-check',   // Іконка адміністратора
        };
    }
}

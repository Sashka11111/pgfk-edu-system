<?php

namespace Liamtseva\PGFKEduSystem\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Position: string implements HasLabel, HasColor, HasIcon
{
    case DIRECTOR = 'director';             // Директор
    case DEPUTY_DIRECTOR = 'deputy';        // Заступник директора
    case HEAD_OF_DEPARTMENT = 'head';       // Завідувач відділення
    case METHODIST = 'methodist';           // Методист
    case SECRETARY = 'secretary';           // Секретар
    case ACCOUNTANT = 'accountant';         // Бухгалтер
    case FACILITY_MANAGER = 'facility';     // Завідувач господарством
    case ADMINISTRATOR = 'admin';           // Адміністратор (базове значення)

    /**
     * Повертає мітку для Filament
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::DIRECTOR => 'Директор',
            self::DEPUTY_DIRECTOR => 'Заступник директора',
            self::HEAD_OF_DEPARTMENT => 'Завідувач відділення',
            self::METHODIST => 'Методист',
            self::SECRETARY => 'Секретар',
            self::ACCOUNTANT => 'Бухгалтер',
            self::FACILITY_MANAGER => 'Завідувач господарством',
            self::ADMINISTRATOR => 'Адміністратор',
        };
    }

    /**
     * Повертає колір для Filament
     */
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DIRECTOR => 'danger',         // Червоний (вища посада)
            self::DEPUTY_DIRECTOR => 'warning', // Жовтий
            self::HEAD_OF_DEPARTMENT => 'info', // Синій
            self::METHODIST => 'success',       // Зелений
            self::SECRETARY => 'primary',       // Фіолетовий
            self::ACCOUNTANT => 'primary',       // Фіолетовий
            self::FACILITY_MANAGER => 'gray', // Сірий
            self::ADMINISTRATOR => 'gray',      // Сірий
        };
    }

    /**
     * Повертає іконку для Filament (опціонально)
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::DIRECTOR => 'heroicon-o-shield-check',
            self::DEPUTY_DIRECTOR => 'heroicon-o-user-group',
            self::HEAD_OF_DEPARTMENT => 'heroicon-o-building-office-2',
            self::METHODIST => 'heroicon-o-book-open',
            self::SECRETARY => 'heroicon-o-document-text',
            self::ACCOUNTANT => 'heroicon-o-calculator',
            self::FACILITY_MANAGER => 'heroicon-o-wrench',
            self::ADMINISTRATOR => 'heroicon-o-user',
        };
    }
}

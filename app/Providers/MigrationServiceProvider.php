<?php

namespace Liamtseva\PGFKEduSystem\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blueprint::macro('enumAlterColumn', function (
            string $columnName,
            string $enumTypeName, // Цей параметр не потрібен для MySQL, але залишаємо для сумісності
            string $enumClass,
            ?string $default = null,
            bool $nullable = false
        ) {
            // Отримуємо значення з PHP Enum
            $values = collect($enumClass::cases())
                ->map(fn($case) => $case->value)
                ->all();

            // Перевіряємо, чи колонка вже існує
            $table = $this->getTable();
            $columnExists = Schema::hasColumn($table, $columnName);

            if ($columnExists) {
                // Зміна існуючої колонки
                return $this->enum($columnName, $values)
                    ->nullable($nullable)
                    ->default($default)
                    ->change();
            } else {
                // Додавання нової колонки
                $column = $this->enum($columnName, $values);
                if ($nullable) {
                    $column->nullable();
                }
                if ($default) {
                    $column->default($default);
                }
                return $column;
            }
        });
    }
}

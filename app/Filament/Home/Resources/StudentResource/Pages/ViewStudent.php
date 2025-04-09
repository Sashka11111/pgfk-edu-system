<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource;
use Liamtseva\PGFKEduSystem\Enums\Role;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        // Якщо користувач — студент, прибираємо всі дії (наприклад, редагування)
        if (auth()->user()->role === Role::STUDENT) {
            return [];
        }

        return [
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        // Перевіряємо, чи студент має доступ лише до свого запису
        if (auth()->user()->role === Role::STUDENT && $this->record->user_id !== auth()->id()) {
            abort(403, 'Ви можете переглядати лише свої дані.');
        }
    }
}

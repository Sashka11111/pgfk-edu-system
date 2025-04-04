<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\TeacherResource\Pages;

use Liamtseva\PGFKEduSystem\Filament\Home\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

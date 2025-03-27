<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

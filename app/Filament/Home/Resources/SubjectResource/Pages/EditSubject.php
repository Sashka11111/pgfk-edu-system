<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\SubjectResource\Pages;

use Liamtseva\PGFKEduSystem\Filament\Home\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubject extends EditRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

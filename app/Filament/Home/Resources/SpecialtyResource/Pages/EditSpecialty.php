<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\SpecialtyResource\Pages;

use Liamtseva\PGFKEduSystem\Filament\Home\Resources\SpecialtyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecialty extends EditRecord
{
    protected static string $resource = SpecialtyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

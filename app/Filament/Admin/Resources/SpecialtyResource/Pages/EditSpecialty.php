<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource;

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

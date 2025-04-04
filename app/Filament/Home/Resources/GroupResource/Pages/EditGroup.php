<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\GroupResource\Pages;

use Liamtseva\PGFKEduSystem\Filament\Home\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

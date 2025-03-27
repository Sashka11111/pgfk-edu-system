<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource;

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

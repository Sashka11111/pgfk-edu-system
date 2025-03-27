<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

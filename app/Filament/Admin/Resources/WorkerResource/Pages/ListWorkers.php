<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource;

class ListWorkers extends ListRecords
{
    protected static string $resource = WorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

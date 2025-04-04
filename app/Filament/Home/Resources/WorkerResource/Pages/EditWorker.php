<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource\Pages;

use Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorker extends EditRecord
{
    protected static string $resource = WorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

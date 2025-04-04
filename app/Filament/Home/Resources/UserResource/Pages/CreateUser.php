<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\UserResource\Pages;

use Liamtseva\PGFKEduSystem\Filament\Home\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}

<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource\Widgets\LatestUsers;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource\Widgets\UserStatsOverview;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            Tab::make('all')
                ->label('Усі користувачі')
                ->icon('heroicon-o-users')
                ->query(fn ($query) => $query),

            Tab::make('admins')
                ->label('Адміністратори')
                ->icon('clarity-administrator-line')
                ->query(fn ($query) => $query->where('role', 'admin')),

            Tab::make('student')
                ->label('Студенти')
                ->icon('heroicon-o-users')
                ->query(fn ($query) => $query->where('role', 'student')),

            Tab::make('teacher')
                ->label('Викладачі')
                ->icon('heroicon-o-academic-cap')
                ->query(fn ($query) => $query->where('role', 'teacher')),

            Tab::make('unverified')
                ->label('Непідтверджені')
                ->icon('heroicon-o-exclamation-triangle')
                ->query(fn ($query) => $query->whereNull('email_verified_at')),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsOverview::class,
            LatestUsers::class,
        ];
    }
}

<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Widgets\WorkersByGenderChart;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Widgets\WorkersByPositionChart;

class ListWorkers extends ListRecords
{
    protected static string $resource = WorkerResource::class;
    public function getTabs(): array
    {
        return [
            Tab::make('Всі працівники')
                ->modifyQueryUsing(fn (Builder $query) => $query)
                ->icon('heroicon-o-users')
                ->badgeColor('gray'),

            Tab::make('Чоловіки')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn (Builder $userQuery) => $userQuery->where('gender', 'male')))
                ->icon('fas-male')
                ->badgeColor('info'),

            Tab::make('Жінки')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn (Builder $userQuery) => $userQuery->where('gender', 'female')))
                ->icon('fas-female')
                ->badgeColor('success'),

            Tab::make('Інше')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn (Builder $userQuery) => $userQuery->where('gender', 'other')))
                ->icon('bx-male-female')
                ->badgeColor('warning'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            WorkersByGenderChart::class,
            WorkersByPositionChart::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

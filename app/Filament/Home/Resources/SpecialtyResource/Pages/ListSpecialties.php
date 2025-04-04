<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\SpecialtyResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\SpecialtyResource;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\SpecialtyResource\Widgets\SpecialtyStatsOverview;
use Liamtseva\PGFKEduSystem\Models\Specialty;

class ListSpecialties extends ListRecords
{
    protected static string $resource = SpecialtyResource::class;
    public function getTabs(): array
    {
        return [
            Tab::make('Всі спеціальності')
                ->modifyQueryUsing(fn (Builder $query) => $query),
            Tab::make('Навчальна частина 1')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('department', 'department_part_1')),
            Tab::make('Навчальна частина 2')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('department', 'department_part_2')),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getHeaderWidgets(): array
    {
        return [
            SpecialtyStatsOverview::class,
        ];
    }
}

<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\GroupResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\GroupResource;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\GroupResource\Widgets\GroupStatsOverview;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;
    public function getTabs(): array
    {
        return [
            Tab::make('Всі групи')
                ->modifyQueryUsing(fn (Builder $query) => $query),
            Tab::make('1-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('year_of_study', 1)),
            Tab::make('2-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('year_of_study', 2)),
            Tab::make('3-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('year_of_study', 3)),
            Tab::make('4-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('year_of_study', 4)),
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
            GroupStatsOverview::class,
        ];
    }
}

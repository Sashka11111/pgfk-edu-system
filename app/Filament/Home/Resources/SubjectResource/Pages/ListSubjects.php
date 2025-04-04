<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\SubjectResource\Pages;

use Filament\Resources\Components\Tab;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\SubjectResource\Widgets\SubjectStatsOverview;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;
    public function getTabs(): array
    {
        return [
            Tab::make('Всі предмети')
                ->icon('heroicon-o-academic-cap'),

            Tab::make('Менше 50 годин')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn ($query) => $query->where('hours', '<', 50)),

            Tab::make('50-100 годин')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn ($query) => $query->whereBetween('hours', [50, 100])),

            Tab::make('Більше 100 годин')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn ($query) => $query->where('hours', '>', 100)),
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
            SubjectStatsOverview::class,
        ];
    }
}

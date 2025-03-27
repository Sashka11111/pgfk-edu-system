<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource\Widgets\CourseStatsOverview;
use Liamtseva\PGFKEduSystem\Models\Course;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;
    public function getTabs(): array
    {
        return [
            Tab::make('Всі курси')
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
            CourseStatsOverview::class,
        ];
    }
}

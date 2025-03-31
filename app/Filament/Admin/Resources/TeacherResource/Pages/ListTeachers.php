<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Widgets\TeacherStatsWidget;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;
    public function getTabs(): array
    {
        return [
            Tab::make('Всі викладачі')
                ->icon('heroicon-o-users')
                ->modifyQueryUsing(fn ($query) => $query),
            Tab::make('Досвід до 5 років')
                ->icon('heroicon-o-briefcase')
                ->modifyQueryUsing(fn ($query) => $query->where('experience_years', '<', 5)),
            Tab::make('Досвід 5-10 років')
                ->icon('heroicon-o-briefcase')
                ->modifyQueryUsing(fn ($query) => $query->whereBetween('experience_years', [5, 10])),
            Tab::make('Досвід більше 10 років')
                ->icon('heroicon-o-briefcase')
                ->modifyQueryUsing(fn ($query) => $query->where('experience_years', '>', 10)),
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
            TeacherStatsWidget::class,
        ];
    }
}

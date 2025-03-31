<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets\StudentsByEnrollmentYearChart;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets\StudentsByGroupChart;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets\StudentStatsWidget;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;
    public function getTabs(): array
    {
        $currentYear = now()->year;

        return [
            Tab::make('Всі студенти')
                ->modifyQueryUsing(fn (Builder $query) => $query),

            Tab::make('1-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('enrollment_date', $currentYear)),

            Tab::make('2-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('enrollment_date', $currentYear - 1)),

            Tab::make('3-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('enrollment_date', $currentYear - 2)),

            Tab::make('4-й курс')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereYear('enrollment_date', $currentYear - 3)),

            Tab::make('Стипендіати')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_scholarship_holder', true)),
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
            StudentsByGroupChart::class,
            StudentsByEnrollmentYearChart::class,
            StudentStatsWidget::class,
        ];
    }
}

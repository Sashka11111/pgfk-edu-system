<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Specialty;

class SpecialtyStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Загальна кількість спеціальностей', Specialty::count())
                ->icon('heroicon-o-book-open'),
            Stat::make('Спеціальностей навчальної частини 1', Specialty::where('department', 'department_part_1')->count())
                ->icon('heroicon-o-cpu-chip'),
            Stat::make('Спеціальностей навчальної частини 2', Specialty::where('department', 'department_part_2')->count())
                ->icon('heroicon-o-document-text'),
        ];
    }
}

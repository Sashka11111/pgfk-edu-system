<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SubjectResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Subject;

class SubjectStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $averageHours = Subject::avg('hours') ?? 0;
        $longCoursesCount = Subject::where('hours', '>', 100)->count();
        return [
            Stat::make('Загальна кількість предметів', Subject::count())
                ->description('Кількість усіх предметів у системі')
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),
            Stat::make('Середня кількість годин', round($averageHours, 2))
                ->description('Середня тривалість предметів')
                ->icon('heroicon-o-clock')
                ->color('success'),
            Stat::make('Предмети більше 100 годин', $longCoursesCount)
                ->description('Кількість тривалих предметів')
                ->icon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}

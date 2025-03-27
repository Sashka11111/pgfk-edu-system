<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Course;

class CourseStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $averageHours = Course::avg('hours') ?? 0;
        $longCoursesCount = Course::where('hours', '>', 100)->count();
        return [
            Stat::make('Загальна кількість курсів', Course::count())
                ->description('Кількість усіх курсів у системі')
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),
            Stat::make('Середня кількість годин', round($averageHours, 2))
                ->description('Середня тривалість курсів')
                ->icon('heroicon-o-clock')
                ->color('success'),
            Stat::make('Курси більше 100 годин', $longCoursesCount)
                ->description('Кількість тривалих курсів')
                ->icon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}

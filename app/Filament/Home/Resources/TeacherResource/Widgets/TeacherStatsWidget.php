<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\TeacherResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Subject;
use Liamtseva\PGFKEduSystem\Models\Teacher;

class TeacherStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Загальна кількість викладачів', Teacher::count())
                ->description('Викладачів у системі')
                ->icon('heroicon-o-users')
                ->color('success'),
            Stat::make('Середній досвід', round(Teacher::avg('experience_years'), 1) . ' років')
                ->description('Середній досвід роботи')
                ->icon('heroicon-o-briefcase')
                ->color('primary'),
            Stat::make('Кількість предметів', Subject::count())
                ->description('Унікальних предметів')
                ->icon('heroicon-o-book-open')
                ->color('info'),
        ];
    }
}

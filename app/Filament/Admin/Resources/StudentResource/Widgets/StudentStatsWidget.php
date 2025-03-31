<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Student;

class StudentStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всього студентів', Student::count())
                ->description('Загальна кількість студентів')
                ->icon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Стипендіатів', Student::where('is_scholarship_holder', true)->count())
                ->description('Студенти, які отримують стипендію')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Середня кількість незарахованих предметів', number_format(Student::avg('failed_subjects'), 2))
                ->description('Середній показник по студентам')
                ->icon('heroicon-o-x-circle')
                ->color('warning'),
        ];
    }
}

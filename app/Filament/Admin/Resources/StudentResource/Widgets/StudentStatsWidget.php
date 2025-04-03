<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Student;

class StudentStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $averageAge = Student::selectRaw('AVG(EXTRACT(YEAR FROM AGE(NOW(), birthdate))) as avg_age')->first()->avg_age;
        $averageAge = round($averageAge, 1);
        return [
            Stat::make('Всього студентів', Student::count())
                ->description('Загальна кількість студентів')
                ->icon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Стипендіатів', Student::where('is_scholarship_holder', true)->count())
                ->description('Студенти, які отримують стипендію')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Середній вік студентів', $averageAge . ' років')
                ->description('На основі дати народження')
                ->icon('heroicon-o-cake')
                ->color('warning'),
        ];
    }
}

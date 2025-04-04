<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Models\User;

class UserStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $teacher = User::where('role', Role::TEACHER)->count();
        $student = User::where('role', Role::STUDENT)->count();

        return [
            Stat::make('Всього користувачів', $totalUsers)
                ->description('Загальна кількість')
                ->color('primary')
                ->icon('heroicon-o-users'),
            Stat::make('Викладачі', $teacher)
                ->description('Кількість викладачів')
                ->color('danger')
                ->icon('heroicon-o-academic-cap'),
            Stat::make('Студенти', $student)
                ->description('Кількість студентів')
                ->color('danger')
                ->icon('heroicon-o-user'),
        ];
    }
}

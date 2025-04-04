<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\GroupResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Liamtseva\PGFKEduSystem\Models\Group;

class GroupStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всього груп', Group::count())
                ->description('Загальна кількість груп')
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary'),
            Stat::make('Груп 1-го року', Group::where('year_of_study', 1)->count())
                ->description('Кількість груп першого курсу')
                ->icon('heroicon-o-calendar')
                ->color('success'),
            Stat::make('Груп цього року', Group::whereYear('created_at', now()->year)->count())
                ->description('Кількість груп, створених у поточному році')
                ->icon('heroicon-o-calendar-days')
                ->color('danger'),
        ];
    }
}

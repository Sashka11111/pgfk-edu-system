<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets\StudentsByEnrollmentYearChart;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets\StudentsByGroupChart;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Widgets\TeacherStatsWidget;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Widgets\WorkersByGenderChart;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Widgets\WorkersByPositionChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Головна';

    protected static ?string $navigationLabel = 'Головна';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected function getHeaderWidgets(): array
    {
        return [
            TeacherStatsWidget::class,
            StudentsByGroupChart::class,
            StudentsByEnrollmentYearChart::class,
            WorkersByGenderChart::class,
            WorkersByPositionChart::class,
        ];
    }
}

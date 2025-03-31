<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources\StudentResource\Widgets;

use Filament\Widgets\ChartWidget;
use Liamtseva\PGFKEduSystem\Models\Student;

class StudentsByEnrollmentYearChart extends ChartWidget
{
    protected static ?string $heading = 'Розподіл студентів за роками вступу';

    protected static ?string $description = 'Кількість студентів, які вступили в різні роки';
    protected static ?string $maxHeight = '230px';

    protected function getData(): array
    {
        // Отримуємо кількість студентів за роками вступу
        $data = Student::query()
            ->selectRaw('EXTRACT(YEAR FROM enrollment_date) as year, COUNT(*) as count')
            ->whereNotNull('enrollment_date')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->pluck('count', 'year')
            ->all();

        return [
            'datasets' => [
                [
                    'label' => 'Студенти',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', // Кольори для секторів
                    ],
                ],
            ],
            'labels' => array_keys($data), // Роки вступу
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Тип графіку: кругова діаграма
    }
}

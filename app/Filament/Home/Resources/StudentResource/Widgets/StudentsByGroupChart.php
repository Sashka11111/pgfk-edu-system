<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Widgets;

use Filament\Widgets\ChartWidget;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\Student;

class StudentsByGroupChart extends ChartWidget
{
    protected static ?string $heading = 'Студенти за групами';

    protected function getData(): array
    {
        $data = Student::query()
            ->selectRaw('group_id, COUNT(*) as count')
            ->groupBy('group_id')
            ->pluck('count', 'group_id')
            ->all();

        $labels = Group::whereIn('id', array_keys($data))
            ->pluck('name')
            ->all();

        return [
            'datasets' => [
                [
                    'label' => 'Кількість студентів',
                    'data' => array_values($data),
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

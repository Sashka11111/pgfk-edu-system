<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource\Widgets;

use Filament\Widgets\ChartWidget;
use Liamtseva\PGFKEduSystem\Enums\Position;
use Liamtseva\PGFKEduSystem\Models\Worker;

class WorkersByPositionChart extends ChartWidget
{
    protected static ?string $heading = 'Розподіл працівників за посадами';
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $data = Worker::query()
            ->selectRaw('position, COUNT(*) as count')
            ->groupBy('position')
            ->pluck('count', 'position')
            ->all();

        $labels = array_map(fn ($value) => Position::tryFrom($value)?->getLabel() ?? $value, array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => 'Працівники',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#F7464A', '#46BFBD',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Кругова діаграма
    }
}

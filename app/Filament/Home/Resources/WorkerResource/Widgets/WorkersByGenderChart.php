<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource\Widgets;

use Filament\Widgets\ChartWidget;
use Liamtseva\PGFKEduSystem\Models\Worker;

class WorkersByGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Розподіл працівників за статтю';
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $maleCount = Worker::whereHas('user', fn ($query) => $query->where('gender', 'male'))->count();
        $femaleCount = Worker::whereHas('user', fn ($query) => $query->where('gender', 'female'))->count();
        $otherCount = Worker::whereHas('user', fn ($query) => $query->where('gender', 'other'))->count();

        return [
            'datasets' => [
                [
                    'label' => 'Працівники',
                    'data' => [$maleCount, $femaleCount,$otherCount],
                    'backgroundColor' => ['#36A2EB', '#FF6384', '#46BFBD'],
                ],
            ],
            'labels' => ['Чоловіки', 'Жінки','Інше'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}

<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;


class TasksByStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Tasks by status';

    protected function getData():array
    {
        $statusCounts = Task::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return [
            'labels' => $statusCounts->keys()->toArray(),
            'datasets' => [
                [
                    'label' => 'Tasks',
                    'data' => $statusCounts->values()->toArray(),
                    'backgroundColor' => ['#f6ad55', '#68d391'], // Example colors
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;

class TasksByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Tasks By Category';

    protected function getData(): array
    {
        $categoryCounts = Task::query()
            ->selectRaw('categories.name, COUNT(tasks.id) as count')
            ->join('categories', 'tasks.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->pluck('count', 'categories.name');

        return [
            'labels' => $categoryCounts->keys()->toArray(),
            'datasets' => [
                [
                    'data' => $categoryCounts->values()->toArray(),
                    'backgroundColor' => ['#4299e1', '#ed64a6', '#48bb78'], // Example colors
                ],
            ],
        ];

    }

    protected function getType(): string
    {
        return 'pie';
    }
}

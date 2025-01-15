<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecentTasksWidget extends BaseWidget
{
    public function getViewData(): array
    {
        // Fetch the latest 5 tasks
        return [
            'recentTasks' => Task::latest()->take(5)->get(),
        ];
    }
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.widgets.recent-tasks-widget', $this->getViewData());
    }
}

<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Models\Task;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = null;
    use InteractsWithPageTable;
    protected function getTablePage(): string
    {
        return ListTasks::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tasks', $this->getPageTableQuery()->count()),
            Stat::make('Completed Tasks', $this->getPageTableQuery()->where('status', 'completed')->count()),
            Stat::make('Pending Tasks', $this->getPageTableQuery()->where('status', 'pending')->count()),
        ];
    }
}

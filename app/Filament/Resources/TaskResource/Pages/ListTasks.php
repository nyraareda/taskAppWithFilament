<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Enums\TaskStatus;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Support\Collection;
use App\Filament\Resources\TaskResource\Widgets\StatsOverview;


class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;
    public Collection $orderByStatuses;
    use ExposesTableToWidgets;
    public function __construct()
    {
        $this->orderByStatuses = Task::select('status', \DB::raw('count(*) as task_count'))
            ->groupBy('status')
            ->pluck('task_count', 'status');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        // Add the StatsOverview widget here
        return [
            StatsOverview::class,
        ];
    }
    public function getTabs():array
    {
        return [
          'pending'=> Tab::make(label: 'Pending Tasks')
              ->badge(badge: $this->orderByStatuses[TaskStatus::Pending->value] ??'0')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', TaskStatus::Pending->value);
            }),
            'completed'=> Tab::make(label: 'Completed Tasks')
                ->badge(badge: $this->orderByStatuses[TaskStatus::Completed->value] ??'0')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', TaskStatus::Completed->value);
            }),
            'all'=> Tab::make(label: 'All Tasks')
            ->badge(badge: $this->orderByStatuses->sum())
        ];
    }
}

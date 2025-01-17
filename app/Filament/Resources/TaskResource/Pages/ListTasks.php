<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Enums\TaskStatus;
use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;


class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs():array
    {
        return [
          'pending'=> Tab::make(label: 'Pending Tasks')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', TaskStatus::Pending->value);
            }),
            'completed'=> Tab::make(label: 'Completed Tasks')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', TaskStatus::Completed->value);
            }),
            'all'=> Tab::make(label: 'All Tasks')
        ];
    }
}

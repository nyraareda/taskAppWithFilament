<x-filament::widget>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">Recent Tasks</h2>
        <div class="space-y-4">
            @foreach ($recentTasks as $task)
                <div class="p-4 bg-white shadow rounded">
                    <h4 class="text-lg font-semibold">{{ $task->title }}</h4>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                    <p class="text-sm text-gray-500">Status: {{ ucfirst($task->status) }}</p>
                    <p class="text-sm text-gray-500">Updated: {{ $task->updated_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>

<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Task::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'deadline' => $this->faker->date(),
            'status' => $this->faker->randomElement([TaskStatus::Pending, TaskStatus::Completed]),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}

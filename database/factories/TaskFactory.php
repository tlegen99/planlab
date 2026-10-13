<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // TODO: статусы задач
        $status = fake()->numberBetween(0, 6);
        $startsAt = fake()->optional(0.6)->dateTimeBetween('-2 months', '+2 weeks');

        return [
            'project_id' => Project::factory(),
            'author_id' => User::factory(),
            'name' => rtrim(fake()->sentence(4), '.'),
            'description' => fake()->optional()->paragraph(),
            'status' => $status,
            'visibility' => fake()->numberBetween(0, 2),
            'priority' => fake()->numberBetween(0, 2),
            'starts_at' => $startsAt,
            'ends_at' => $startsAt ? fake()->optional(0.8)->dateTimeBetween($startsAt, '+2 months') : null,
            'completed_at' => $status === 1 ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    /**
     * Задача без проекта.
     */
    public function withoutProject(): static
    {
        return $this->state(fn () => ['project_id' => null]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([
            Project::STATUS_IN_PROGRESS,
            Project::STATUS_DONE,
            Project::STATUS_PLANNED,
            Project::STATUS_ON_APPROVAL,
            Project::STATUS_PAUSED,
            Project::STATUS_FAILED,
            Project::STATUS_OBSOLETE,
        ]);

        if ($status === Project::STATUS_DONE) {
            $startsAt = fake()->dateTimeBetween('-6 months', '-1 month');
            $completedAt = fake()->dateTimeBetween($startsAt, 'now');
        } else {
            $startsAt = fake()->optional(0.8)->dateTimeBetween('-3 months', '+1 month');
            $completedAt = null;
        }

        return [
            'author_id' => User::factory(),
            'lead_id' => null,
            'code' => strtoupper(fake()->unique()->lexify('????')),
            'name' => fake()->catchPhrase(),
            'description' => fake()->optional()->paragraph(),
            'status' => $status,
            'visibility' => fake()->numberBetween(0, 2),
            'priority' => fake()->numberBetween(0, 2),
            'starts_at' => $startsAt,
            'ends_at' => $startsAt ? fake()->optional(0.7)->dateTimeBetween($startsAt, '+6 months') : null,
            'completed_at' => $completedAt,
        ];
    }
}

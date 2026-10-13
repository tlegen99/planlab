<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $author = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $leads = User::factory(4)->create();

        Project::factory(30)
            ->create([
                'author_id' => $author->id,
                'lead_id' => fn () => fake()->optional(0.7)->randomElement($leads->pluck('id')->all()),
            ])
            ->each(fn (Project $project) => Task::factory(fake()->numberBetween(5, 10))->create([
                'project_id' => $project->id,
                'author_id' => $author->id,
            ]));

        Task::factory(5)->withoutProject()->create(['author_id' => $author->id]);
    }
}

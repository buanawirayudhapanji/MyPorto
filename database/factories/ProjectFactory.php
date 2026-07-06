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
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement([
                'Web Development',
                'Mobile App Development',
                'Desktop Application',
            ]),
            'tech_stack' => ['PHP', 'Laravel', 'Tailwind CSS'],
            'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
            'description' => $this->faker->paragraph(),
            'project_url' => $this->faker->url(),
            'github_url' => $this->faker->url(),
            'status' => 'published',
            'images' => ['projects/dummy.png'],
        ];
    }
}

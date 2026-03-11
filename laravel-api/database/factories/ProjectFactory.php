<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
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
        return [
            'title' => [
                'en' => $this->faker->sentence(3),
                'de' => $this->faker->sentence(3),
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'de' => $this->faker->paragraph(),
            ],
            'slug' => $this->faker->unique()->slug(),
            'is_published' => false,
            'tech_stack' => ['Laravel', 'Vue'],
            'published_at' => null,
            'status' => 'planned',
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_published' => true,
                'published_at' => now(),
            ];
        });
    }
}

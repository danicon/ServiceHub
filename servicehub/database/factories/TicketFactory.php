<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id'  => Project::factory(),
            'user_id'     => User::factory(),
            'title'       => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(['open', 'in_progress', 'closed']),
            'priority'    => fake()->randomElement(['low', 'medium', 'high']),
        ];
    }
}
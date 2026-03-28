<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id'         => Ticket::factory(),
            'technical_notes'   => fake()->sentence(),
            'enriched_data'     => ['key' => 'value'],
            'responsible_email' => fake()->email(),
            'processed_at'      => now(),
        ];
    }
}
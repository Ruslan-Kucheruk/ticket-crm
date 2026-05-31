<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'subject' => fake()->sentence(4), 
            'message' => fake()->paragraph(), 
            'status' => fake()->randomElement(['new', 'in_progress', 'processed']), 
            'manager_replied_at' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = Client::inRandomOrder()->first();

        return [
            'order_number' => $this->faker->unique()->numerify('ORD-#####'),
            'client_id' => $client->id,
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}

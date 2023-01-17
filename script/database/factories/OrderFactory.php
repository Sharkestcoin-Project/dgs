<?php

namespace Database\Factories;

use App\Models\Gateway;
use App\Models\Plan;
use App\Models\User;
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
    public function definition()
    {
        return [
            "user_id" => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            "plan_id" => Plan::inRandomOrder()->first()->id ?? Plan::factory()->create()->id,
            "gateway_id" => Gateway::inRandomOrder()->first()->id ?? Gateway::factory()->create()->id,
            "trx" => \Str::random(5),
            "is_auto" => $this->faker->boolean(),
            "tax" => $this->faker->numberBetween(1, 5),
            "will_expire" => today()->addDays($this->faker->numberBetween(1, 30)),
            "price" => $this->faker->numberBetween(50, 500),
            "type" => 'order',
            "status" => $this->faker->numberBetween(0, 3),
            "payment_status" => $this->faker->numberBetween(0, 3),
            'created_at' => $this->faker->date(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "avatar" => 'https://api.lorem.space/image/face?w=200&h=200',
            "username" => $this->faker->unique()->userName(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->unique()->safeEmail(),
            "role" => 'user',
            "password" => bcrypt('password'),
            "plan_id" => Plan::inRandomOrder()->first()->id,
            "will_expire" => today()->addDays($this->faker->numberBetween(1,60)),
            "status" => 1,
            "email_verified_at" => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function ($model){
            Product::factory($this->faker->numberBetween(1, 5))->create(['user_id' => $model->id]);
        });
    }
}

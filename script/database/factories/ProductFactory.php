<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->colorName(),
            "description" => $this->faker->paragraph(),
            "price" => $this->faker->randomFloat(2, 0, 500),
            "buyer_can_set_price" => $this->faker->boolean(),
            "file" => $this->faker->imageUrl(),
            "cover" => $this->faker->imageUrl(),
            "return_url" => $this->faker->url(),
            "theme_color" => $this->faker->hexColor(),
            "meta" => null,
            "currency_id" => Currency::inRandomOrder()->first()->id,
            'user_id' => User::whereNot('role', 'admin')->inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'created_at' => $this->faker->dateTimeBetween($this->faker->numberBetween(1, 10)),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($model){
            ProductOrder::factory($this->faker->numberBetween(1, 20))->create(['user_id' => $model->user_id, 'product_id' => $model->id]);
        });
    }
}

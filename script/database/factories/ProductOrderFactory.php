<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductOrder>
 */
class ProductOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        return [
            'uuid' => $this->faker->unique()->uuid(),
            'invoice_no' => \Str::random(5),
            'trx' => \Str::random(8),
            'email' => $this->faker->email(),
            'amount' => $product->price,
            'product_id' => $product->id,
            'user_id' => User::whereNot('role', 'admin')->inRandomOrder()->first()->id ?? User::factory()->id,
            'gateway_id' => Gateway::inRandomOrder()->first()->id,
            'currency_id' => Currency::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween(today()->subYears($this->faker->numberBetween(1, 10))),
        ];
    }
}

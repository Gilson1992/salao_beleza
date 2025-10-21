<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'unit' => $this->faker->randomElement(['un', 'ml', 'g']),
            'stock_quantity' => $this->faker->numberBetween(5, 50),
            'minimum_stock' => $this->faker->numberBetween(2, 10),
            'is_active' => true,
        ];
    }
}

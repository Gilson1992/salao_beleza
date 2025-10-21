<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemPrice>
 */
class ItemPriceFactory extends Factory
{
    protected $model = ItemPrice::class;

    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'price' => $this->faker->randomFloat(2, 10, 150),
            'starts_at' => now()->subDays($this->faker->numberBetween(0, 30)),
            'ends_at' => null,
            'created_by' => User::factory(),
        ];
    }
}

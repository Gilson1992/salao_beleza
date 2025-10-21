<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemPriceHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemPriceHistory>
 */
class ItemPriceHistoryFactory extends Factory
{
    protected $model = ItemPriceHistory::class;

    public function definition(): array
    {
        $oldPrice = $this->faker->randomFloat(2, 10, 120);
        $newPrice = $oldPrice + $this->faker->randomFloat(2, -10, 10);

        return [
            'item_id' => Item::factory(),
            'old_price' => $oldPrice,
            'new_price' => max(1, $newPrice),
            'changed_by' => User::factory(),
            'changed_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemPriceHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ItemPriceSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        Item::all()->each(function (Item $item) use ($admin) {
            $price = rand(20, 120);
            $startsAt = Carbon::now()->subDays(rand(0, 10));

            $item->prices()->create([
                'price' => $price,
                'starts_at' => $startsAt,
                'created_by' => $admin?->id,
            ]);

            ItemPriceHistory::create([
                'item_id' => $item->id,
                'old_price' => $price,
                'new_price' => $price,
                'changed_by' => $admin?->id,
                'changed_at' => $startsAt,
            ]);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Shampoo Hidratante',
                'description' => 'Shampoo profissional para hidratação intensa.',
                'unit' => 'ml',
                'stock_quantity' => 20,
                'minimum_stock' => 5,
            ],
            [
                'name' => 'Máscara Capilar',
                'description' => 'Máscara capilar de reconstrução.',
                'unit' => 'ml',
                'stock_quantity' => 15,
                'minimum_stock' => 5,
            ],
            [
                'name' => 'Esmalte Vermelho',
                'description' => 'Esmalte profissional vermelho vivo.',
                'unit' => 'un',
                'stock_quantity' => 30,
                'minimum_stock' => 10,
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(['name' => $item['name']], $item + ['is_active' => true]);
        }
    }
}

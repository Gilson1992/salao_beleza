<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemPriceHistoryResource;
use App\Models\Item;

class ItemPriceHistoryController extends Controller
{
    public function index(Item $item)
    {
        $history = $item->priceHistories()
            ->with('author')
            ->orderByDesc('changed_at')
            ->paginate(15);

        return ItemPriceHistoryResource::collection($history);
    }
}

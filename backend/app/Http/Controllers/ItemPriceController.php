<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemPriceRequest;
use App\Http\Resources\ItemPriceResource;
use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\ItemPriceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ItemPriceController extends Controller
{
    public function index(Request $request)
    {
        $prices = ItemPrice::query()
            ->with(['item', 'author'])
            ->latest('starts_at')
            ->paginate(15);

        return ItemPriceResource::collection($prices);
    }

    public function store(ItemPriceRequest $request)
    {
        $data = $request->validated();

        $price = DB::transaction(function () use ($data, $request) {
            /** @var Item $item */
            $item = Item::findOrFail($data['item_id']);
            $now = Carbon::parse($data['starts_at']);

            $current = $item->prices()
                ->where(function ($query) use ($now) {
                    $query->whereNull('ends_at')
                        ->orWhere('ends_at', '>', $now);
                })
                ->latest('starts_at')
                ->first();

            if ($current) {
                $current->update(['ends_at' => $now]);

                ItemPriceHistory::create([
                    'item_id' => $item->id,
                    'old_price' => $current->price,
                    'new_price' => $data['price'],
                    'changed_by' => $request->user()?->id,
                    'changed_at' => now(),
                ]);
            } else {
                ItemPriceHistory::create([
                    'item_id' => $item->id,
                    'old_price' => $data['price'],
                    'new_price' => $data['price'],
                    'changed_by' => $request->user()?->id,
                    'changed_at' => now(),
                ]);
            }

            return $item->prices()->create([
                'price' => $data['price'],
                'starts_at' => $now,
                'ends_at' => $data['ends_at'] ?? null,
                'created_by' => $request->user()?->id,
            ]);
        });

        return (new ItemPriceResource($price->load('item')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ItemPrice $itemPrice): ItemPriceResource
    {
        return new ItemPriceResource($itemPrice->load(['item', 'author']));
    }

    public function update(ItemPriceRequest $request, ItemPrice $itemPrice): ItemPriceResource
    {
        $data = $request->validated();
        $itemPrice->update($data);

        return new ItemPriceResource($itemPrice->load('item'));
    }

    public function destroy(ItemPrice $itemPrice)
    {
        $itemPrice->delete();

        return response()->noContent();
    }
}

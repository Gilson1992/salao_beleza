<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query()->with('currentPrice');

        if ($search = $request->query('search')) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        $items = $query->orderBy('name')->paginate(15);

        return ItemResource::collection($items);
    }

    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());

        return (new ItemResource($item->load('currentPrice')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Item $item): ItemResource
    {
        return new ItemResource($item->load('currentPrice'));
    }

    public function update(ItemRequest $request, Item $item): ItemResource
    {
        $item->update($request->validated());

        return new ItemResource($item->load('currentPrice'));
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->noContent();
    }
}

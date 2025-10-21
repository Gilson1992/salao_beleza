<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\ItemPrice
 */
class ItemPriceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'price' => $this->price,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'item' => new ItemResource($this->whenLoaded('item')),
            'author' => new UserResource($this->whenLoaded('author')),
        ];
    }
}

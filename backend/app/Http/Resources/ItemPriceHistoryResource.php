<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\ItemPriceHistory
 */
class ItemPriceHistoryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'old_price' => $this->old_price,
            'new_price' => $this->new_price,
            'changed_by' => $this->changed_by,
            'changed_at' => $this->changed_at,
            'author' => new UserResource($this->whenLoaded('author')),
        ];
    }
}

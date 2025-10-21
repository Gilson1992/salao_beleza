<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Appointment
 */
class AppointmentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'scheduled_at' => $this->scheduled_at,
            'notes' => $this->notes,
            'status' => $this->status->value,
            'service_id' => $this->service_id,
            'professional_id' => $this->professional_id,
            'created_by' => $this->created_by,
            'service' => new ServiceResource($this->whenLoaded('service')),
            'professional' => new UserResource($this->whenLoaded('professional')),
            'author' => new UserResource($this->whenLoaded('author')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

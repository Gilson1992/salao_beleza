<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'scheduled_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:'.collect(AppointmentStatus::cases())->map->value->implode(',')],
            'service_id' => ['required', 'exists:services,id'],
            'professional_id' => ['nullable', 'exists:users,id'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemPriceRequest extends FormRequest
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
        $required = $this->isMethod('post') ? 'required' : 'sometimes';

        return [
            'item_id' => [$required, 'exists:items,id'],
            'price' => [$required, 'numeric', 'min:0'],
            'starts_at' => [$required, 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
        ];
    }
}

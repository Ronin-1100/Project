<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'count' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'integer', 'min:1'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'discount_sum' => ['nullable', 'decimal:2', 'min:1'],
            'discount_percent' => ['nullable', 'integer', 'min:1'],
        ];
    }
}

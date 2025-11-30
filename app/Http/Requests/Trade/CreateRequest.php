<?php

namespace App\Http\Requests\Trade;

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
            'count' => ['required', 'integer'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'price' => ['required', 'integer'],
            'promotion_id' => ['nullable', 'integer', 'exists:promotions,id'],
        ];
    }
}

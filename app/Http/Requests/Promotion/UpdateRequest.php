<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['integer', 'exists:products'],
            'count' => ['integer', 'min:1'],
            'price' => ['integer', 'min:1'],
            'user_id' => ['integer', 'exists:users,id'],
            'discount_sum' => ['decimal:2', 'min:1'],
            'discount_percent' => ['integer', 'min:1'],
        ];
    }
}

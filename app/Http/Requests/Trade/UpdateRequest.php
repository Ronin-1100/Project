<?php

namespace App\Http\Requests\Trade;

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
            'product_id' => ['integer',  'exists:products,id'],
            'count' => ['integer',],
            'user_id' => ['integer', 'exists:users,id'],
            'price' => ['integer', 'min:1'],
            'promo_id' => ['integer', 'exists:promotions,id'],
        ];
    }
}

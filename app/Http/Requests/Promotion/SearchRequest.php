<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string'],
            'sort_type' => ['string', Rule::in(['asc', 'desc'])],
            'with_deleted' => ['boolean'],
            'product_id' => ['integer', Rule::exists('products', 'id')],
            'per_page' => ['integer', 'min:5', 'max:100'],
            'page' => ['integer'],
        ];
    }
}

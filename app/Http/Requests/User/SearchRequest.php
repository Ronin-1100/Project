<?php

namespace App\Http\Requests\User;

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
            'email' => ['string'],
            'with_deleted' => ['boolean'],
            'product_id' => ['integer', 'exists:products,id'],
            'sort_type' => ['string', Rule::in(['asc', 'desc'])],
            'per_page' => ['integer', 'min:5', 'max:100'],
            'page' => ['integer'],
        ];
    }
}

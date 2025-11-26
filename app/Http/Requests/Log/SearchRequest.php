<?php

namespace App\Http\Requests\Log;

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
            'sort_type' => ['string', Rule::in(['asc', 'desc'])],

            'price' => ['numeric'],
            'name' => ['string'],
            'count' => ['integer'],

            'per_page' => ['integer', 'min:5', 'max:100'],
            'page' => ['integer'],
        ];
    }
}

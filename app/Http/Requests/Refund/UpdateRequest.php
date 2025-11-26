<?php

namespace App\Http\Requests\Refund;

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
            'trade_id' => ['integer',  'exists:trades,id'],
            'count' => ['integer',],
            'user_id' => ['integer', 'exists:users,id'],
            'price' => ['integer', 'min:1'],
            'reason' => ['string', 'min:3', 'max:255'],
        ];
    }
}

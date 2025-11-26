<?php

namespace App\Http\Requests\Refund;

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
            'trade_id' => ['required', 'integer', 'exists:trades,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'count' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'reason' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}

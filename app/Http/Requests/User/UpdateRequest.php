<?php

namespace App\Http\Requests\User;

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
            'name' => ['string', 'min:3', 'max:255'],
            'email' => ['string', 'email'],
            'password' => ['string', 'min:8', 'confirmed'],
        ];
    }
}

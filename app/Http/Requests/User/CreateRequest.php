<?php

namespace App\Http\Requests\User;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'min:3', 'max:255', 'required'],
            'email' => ['string', 'required', 'email', 'unique:users,email'],
            'password' => ['string', 'min:8', 'confirmed', 'required'],
            'type' => ['required', 'integer', Rule::enum(UserType::class)],
        ];
    }
}

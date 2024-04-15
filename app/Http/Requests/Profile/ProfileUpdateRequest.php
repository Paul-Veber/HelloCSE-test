<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'first_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            //'image' => ['string', 'max:255'],
            'status' => [
                'string', Rule::in(['active', 'waiting', 'inactive', null])
            ],
        ];
    }
}

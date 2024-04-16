<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'image' => ['file', File::image()
                ->min(1024)
                ->max(10 * 1024)
                ->dimensions(
                    Rule::dimensions()
                        ->maxWidth(1000)
                        ->maxHeight(1000)
                )],
            'status' => [
                'string', Rule::in(['active', 'waiting', 'inactive'])
            ],
        ];
    }
}

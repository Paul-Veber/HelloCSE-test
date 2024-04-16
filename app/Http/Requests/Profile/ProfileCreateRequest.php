<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'file', File::image()
                ->min(1)
                ->max(10 * 1024)
                ->dimensions(
                    Rule::dimensions()
                        ->maxWidth(1000)
                        ->maxHeight(1000)
                )],
            'status' => ['required', 'string', Rule::in(['active', 'waiting', 'inactive'])],
        ];
    }
}

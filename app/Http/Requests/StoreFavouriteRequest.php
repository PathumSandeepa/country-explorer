<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavouriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_code' => 'required|string',
            'name' => 'required|string',
            'capital' => 'nullable|string',
            'flag_url' => 'nullable|url',
            'personal_note' => 'nullable|string|max:500',
        ];
    }
}

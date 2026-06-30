<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderLogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'desktop_logo' => ['nullable', 'integer', 'exists:media,id'],
            'mobile_logo' => ['nullable', 'integer', 'exists:media,id'],
            'sticky_logo' => ['nullable', 'integer', 'exists:media,id'],
            'dark_logo' => ['nullable', 'integer', 'exists:media,id'],
            'light_logo' => ['nullable', 'integer', 'exists:media,id'],
            'favicon' => ['nullable', 'integer', 'exists:media,id'],
            'status' => ['sometimes', 'boolean'],
        ];
    }
}

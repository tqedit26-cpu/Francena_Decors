<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'header_style' => ['required', 'string', 'max:100'],
            'sticky_header' => ['sometimes', 'boolean'],
            'transparent_header' => ['sometimes', 'boolean'],
            'topbar_enabled' => ['sometimes', 'boolean'],
            'navbar_enabled' => ['sometimes', 'boolean'],
            'search_enabled' => ['sometimes', 'boolean'],
            'cta_button_enabled' => ['sometimes', 'boolean'],
            'cta_button_text' => ['nullable', 'string', 'max:191'],
            'cta_button_url' => ['nullable', 'url', 'max:500'],
            'cta_button_target' => ['required', 'in:_self,_blank'],
            'mobile_menu_enabled' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'boolean'],
        ];
    }
}

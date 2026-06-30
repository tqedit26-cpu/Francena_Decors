<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:191'],
            'alt_text' => ['nullable', 'string', 'max:191'],
            'caption' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:1000'],
            'folder' => ['required', 'string', 'max:100'],
            'status' => ['sometimes', 'boolean'],
        ];
    }
}

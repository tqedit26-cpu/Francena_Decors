<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaStoreRequest extends FormRequest
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
            'files' => ['required', 'array', 'max:20'],
            'files.*' => ['required', 'file', 'mimes:png,jpg,jpeg,webp,svg,pdf,docx,xlsx,zip', 'max:10240'],
            'folder' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'files.required' => 'Please select at least one file to upload.',
            'files.*.mimes' => 'Only PNG, JPG, JPEG, WEBP, SVG, PDF, DOCX, XLSX and ZIP files are allowed.',
            'files.*.max' => 'Each file must not exceed 10 MB.',
        ];
    }
}

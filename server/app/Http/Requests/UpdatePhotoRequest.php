<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'sometimes|required|file|image|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Image file is required when updating.',
            'image.file'     => 'Image must be a file.',
            'image.image'    => 'Please upload a valid image file.',
            'image.max'      => 'Image may not be greater than 5MB.',
        ];
    }
}
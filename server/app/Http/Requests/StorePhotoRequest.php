<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoRequest extends FormRequest
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
            'dogId' => 'required|integer|exists:dogs,id', // A kutyanak leteznie kell
            'image' => 'required|file|image|max:5120', // Max 5MB
        ];
    }

    public function messages()
    {
        return [
            'dogId.required' => 'Dog is required.',
            'dogId.integer'  => 'Dog ID must be an integer.',
            'dogId.exists'   => 'The selected dog does not exist.',

            'image.required' => 'Image file is required.',
            'image.file'     => 'Image must be a file.',
            'image.image'    => 'Please upload a valid image file.',
            'image.max'      => 'Image may not be greater than 5MB.',
        ];
    }

}
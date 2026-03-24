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
            'dogId' => 'required|integer|exists:dogs,id', // A kutyának léteznie kell
            'imgUrl' => 'required|url|max:2048', // Az imgUrl szükséges és valid URL kell hogy legyen
        ];
    }

    public function messages()
{
    return [
        'dogId.required' => 'Dog is required.',
        'dogId.integer'  => 'Dog ID must be an integer.',
        'dogId.exists'   => 'The selected dog does not exist.',

        'imgUrl.required' => 'Image URL is required.',
        'imgUrl.url'      => 'Please provide a valid URL.',
        'imgUrl.max'      => 'Image URL may not be greater than 2048 characters.',
    ];
}

}

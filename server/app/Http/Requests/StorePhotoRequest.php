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
            'imgUrl' => 'required|url|max:255', // Az imgUrl szükséges és valid URL kell hogy legyen
        ];
    }
}

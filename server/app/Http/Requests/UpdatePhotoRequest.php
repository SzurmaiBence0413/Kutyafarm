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
        // Az 'id' paraméter lekérése a route-ból
        $photoId = $this->route('photo'); // A route paraméterben elvárjuk a photo ID-t.

        return [
            'imgUrl' => 'required|url|max:255|unique:photos,imgUrl,' . $photoId, // A kép URL-je érvényes URL, és nem lehet duplikált
        ];
    }
}

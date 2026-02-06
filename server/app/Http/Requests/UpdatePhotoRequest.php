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
    // A route-ból kinyerjük a fotó ID-ját az egyediség vizsgálatához
    $photoId = $this->route('photo');

    return [
        // Kép URL validáció sometimes-szal
        'imgUrl' => 'sometimes|required|url|max:255|unique:photos,imgUrl,' . $photoId,
    ];
}

public function messages(): array
{
    return [
        'imgUrl.required' => 'A kép URL címének megadása kötelező!',
        'imgUrl.url'      => 'Kérlek, érvényes internetes címet (URL) adj meg!',
        'imgUrl.max'      => 'A kép címe nem lehet hosszabb 255 karakternél!',
        'imgUrl.unique'   => 'Ez a kép URL már szerepel az adatbázisban!',
    ];
}
}

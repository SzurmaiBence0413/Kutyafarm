<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdoptionRequest extends FormRequest
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
            'dogId' => ['required', 'integer', 'exists:dogs,id'],
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'dogId.required' => 'Selecting a dog is required.',
            'dogId.integer' => 'Dog ID must be a number.',
            'dogId.exists' => 'The selected dog does not exist.',

            'fullName.required' => 'Full name is required.',
            'fullName.string' => 'Full name must be a string.',
            'fullName.max' => 'Full name may not be greater than 255 characters.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email address may not be greater than 255 characters.',

            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.max' => 'Phone number may not be greater than 50 characters.',

            'city.required' => 'City is required.',
            'city.string' => 'City must be a string.',
            'city.max' => 'City may not be greater than 255 characters.',

            'message.string' => 'Message must be a string.',
            'message.max' => 'Message may not be greater than 2000 characters.',
        ];
    }
}

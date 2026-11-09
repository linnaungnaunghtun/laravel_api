<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            "images" => "required|array|min:1|max:10",
            "images.*" => "required|image|mimes:jpeg,png,jpg,gif,webp|max:10240",
        ];
    }


    public function messages(): array
    {
        return [
            'images.required' => 'Please upload at least one image.',
            'images.array' => 'The images field must be an array.',
            'images.min' => 'You must upload at least :min images.',
            'images.max' => 'You cannot upload more than :max images.',
            'images.*.required' => 'Each image is required.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Images must be of type: jpeg, png, gif, webp or jpg.',
            'images.*.max' => 'Each image must not exceed 10MB.',
        ];
    }
}

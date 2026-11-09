<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|unique:products,product_code,' . $this->route('product'),
            'description' => 'required|string',
            "gender" => "nullable|string|in:" . join(",", config('base.product_genders')),
            "category_id" => "required|exists:categories,id",
            "product_type_id" => "required|exists:product_types,id",
            "brand_id" => "required|exists:brands,id",
            "fit_id" => "nullable|exists:fits,id",
            "original_price" => "required|numeric",
            "display_price" => "required|numeric",
            "discount" => "nullable|integer",
            "is_archive" => "nullable|date",
            "is_ecommerce" => "nullable|boolean",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherItemRequest extends FormRequest
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
            'voucher_id' => 'required|integer|exists:vouchers,id',
            'product_id' => 'required|integer|exists:products,id',
            'barcode' => 'required|string|exists:stocks,barcode',
            "price" => "required|integer",
            "quantity" => "nullable|integer",
            'discount_percent' => "nullable|integer",
            'discount_cash' => "nullable|integer",
            'cost' => "required|integer",
        ];
    }
}

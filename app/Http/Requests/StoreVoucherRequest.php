<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            "voucher_no" => "required|unique:vouchers,voucher_no",
            "items" => "required|array",
            "items.*.barcode" => "required|exists:stocks,barcode",
        ];
    }

    public function messages(): array
    {
        return [


            "items.required" => "The items field is required.",

            "items.*.barcode.required" => "The barcode field for each item is required.",

            "items.*.barcode.exists" => "Stock with barcode ':input' is invalid.",
        ];
    }
}

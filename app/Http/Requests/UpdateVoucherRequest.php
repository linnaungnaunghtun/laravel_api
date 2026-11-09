<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
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
            'customer_id' => 'required|integer|exists:customers,id',
            "type" => "required|string|in:" . join(",", config('base.types')),
            "payment_method" => "required|string|in:" . join(",", config('base.payment_methods')),
            'discount_percent' => "nullable|integer",
            'discount_cash' => "nullable|integer",
            'tax' => "nullable|integer",
        ];
    }
}

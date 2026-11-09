<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'item_count'     => 'required|integer|min:1',
            'total'          => 'required|integer|min:0',
            'discount'       => 'nullable|integer|min:0',
            'coupon_code'    => 'nullable|string',
            'status'         => 'nullable|in:pending,confirmed,delivering,delivered,cancel',
            'cancel_message' => 'nullable|string',
            'address_id'     => 'required|exists:addresses,id',
            'cancel_user_id' => 'nullable|integer',
        ];
    }
}

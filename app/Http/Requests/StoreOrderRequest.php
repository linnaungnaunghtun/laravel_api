<?php

namespace App\Http\Requests;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
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
        return
            [
                'address_id' => [
                    'required',
                    'integer',
                    // Custom rule to check if the address exists and belongs to the authenticated user
                    function ($attribute, $value, $fail) {
                        // Fetch the address from the database
                        $address = Address::where('id', $value)->first();

                        // Check if the address exists
                        if (!$address) {
                            $fail('The selected address is invalid.');
                            return;
                        }

                        // Check if the address belongs to the authenticated user
                        if ($address->user_id !== Auth::id()) {
                            $fail('You do not have permission to use this address.');
                        }
                    },
                ],
                'coupon_code' => [
                    'nullable',
                    'exists:coupons,code',
                    function ($attribute, $value, $fail) {
                        // Fetch the coupon from the database
                        $coupon = Coupon::where('code', $value)->first();
                        if ($coupon) {
                            // Check if the coupon is archived
                            if ($coupon->is_archive) {
                                $fail('The coupon code is invalid because it is archived.');
                            }

                            // Check if the coupon is expired
                            if (Carbon::now()->gt($coupon->expire_date)) {
                                $fail('The coupon code is invalid because it has expired.');
                            }
                        }
                    },
                ],
                'items' => 'required|array|min:1',
                'items.*' => [
                    function ($attribute, $value, $fail) {
                        // Extract product_id and size_id from the request
                        $productId = $value['id'];
                        $sizeId = $value['size_id'];

                        // Check if the combination of product_id and size_id exists in the stocks table
                        $stock = Stock::where('product_id', $productId)
                            ->where('size_id', $sizeId)
                            ->first();

                        if (!$stock) {
                            $fail("The product '{$value['product_name']}' is not available for size '{$value['size_name']}'.");
                        }
                    },
                ],
            ];
    }
}

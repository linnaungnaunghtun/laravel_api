<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'customer' => $this->user->customer,
            'address_id' => $this->address_id,
            'address' => $this->address,
            'order_items' => $this->orderItems,
            'item_count' => $this->item_count,
            'total' => $this->total,
            'net_total' => $this->net_total,
            'level_discount_percentage' => $this->level_discount_percentage,
            'level_discount_amount' => $this->level_discount_amount,
            'coupon_discount_amount' => $this->coupon_discount_amount,
            'coupon_discount_percentage' => $this->coupon_discount_percentage,
            'coupon_code' => $this->coupon_code,
            'coupon' => new CouponResource($this->coupon),
            'status' => $this->status,
            'is_cancel' => $this->is_cancel,
            'cancel_message' => $this->cancel_message,
            'cancel_user_id' => $this->cancel_user_id,
            'confirm_message' => $this->confirm_message,
            'delivery_date_range' => $this->delivery_date_range,
            'order_id' => $this->order_id,
            'voucher_id' => $this->voucher_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

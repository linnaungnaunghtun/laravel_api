<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "cash_discount" => $this->cash_discount,
            "customer_id" => $this->customer_id,
            "customer" => $this->customer,
            "discount_percent_amount" => $this->discount_percent_amount,
            "discount_percentage" => $this->discount_percentage,
            "net_total" => $this->net_total,
            "payment_method" => $this->payment_method,
            "sale_type" => $this->sale_type,
            "tax" => $this->tax,
            "tax_amount" => $this->tax_amount,
            "total" => $this->total,
            "net_profit" => $this->net_profit,
            "voucher_date" => $this->voucher_date,
            "voucher_no" => $this->voucher_no,
            "user_id" => $this->user_id,
            "user" => $this->user,
            "voucher_items" => $this->voucherItems,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}

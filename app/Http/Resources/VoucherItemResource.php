<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "voucher" => $this->voucher,
            "product" => $this->product,
            "barcode" => $this->barcode,
            "quantity" => $this->quantity,
            "price"=> $this->price,
            "profit"=> $this->profit,
            "discount_percent"=> $this->discount_percent,
            "discount_cash"=> $this->discount_cash,
            "cost"=> $this->cost,
            "user"=> $this->user,
            "created_at" => $this->created_at,
            "updated_at"=> $this->updated_at

        ];
    }
}

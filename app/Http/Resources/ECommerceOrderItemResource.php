<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ECommerceOrderItemResource extends JsonResource
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
            // 'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'product' => new ECommerceProductResource($this->product),
            'size_id' => $this->size_id,
            // 'stock_id' => $this->stock_id,
            'display_price' => $this->display_price,
            'discount' => $this->discount,
            'sale_price' => $this->sale_price,
            // 'created_at' => $this->created_at->toDateTimeString(),
            // 'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

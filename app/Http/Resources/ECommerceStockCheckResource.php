<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ECommerceStockCheckResource extends JsonResource
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
            'product_id' => $this->product_id,
            'shop_code' => $this->shop_code,
            'barcode' => $this->barcode,
            'size_id' => $this->size_id,
            // 'size' => $this->size,
            // 'product' => $this->product,
            // 'user' => $this->user,
            // 'is_sold' => $this->is_sold,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}

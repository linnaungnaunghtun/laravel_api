<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'order_id'   => $this->order,
            'product_id' => $this->product,
            'stock_id'   => $this->stock,
            'is_sold'    => $this->is_sold,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

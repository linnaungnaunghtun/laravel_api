<?php

namespace App\Http\Resources;

use Google\Service\AdExchangeBuyerII\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ECommerceProductResource extends JsonResource
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
            "product_name" => $this->product_name,
            "product_code" => $this->product_code,
            "gender" => $this->gender,
            "slug" => $this->slug,
            "brand_id" => $this->brand_id,
            "brand_name" => $this->brand->brand_name,
            "product_image" => new ECommerceProductImageResource($this->productImage),
            "display_price" => $this->display_price,
            "discount" => $this->discount,
            "sizes" => $this->sizes,
            "available_size" => $this->available_size ? explode(".", trim($this->available_size, ".")) : [],
            "sale_price" => $this->sale_price,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ECommerceSearchSuggestionResource extends JsonResource
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
            "slug" => $this->slug,
            "brand_name" => $this->brand->brand_name,
            "product_image" => new ECommerceProductImageResource($this->productImage),
        ];
        return parent::toArray($request);
    }
}

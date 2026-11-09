<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "description" => $this->description,
            "gender" => $this->gender,
            "brand_id" => $this->brand_id,
            "brand" => $this->brand,
            "product_type_id" => $this->product_type_id,
            "product_type" => $this->productType,
            "product_images" => ProductImageResource::collection($this->productImages),
            "category_id" => $this->category_id,
            "category" => new CategoryResource($this->category),
            "fit_id" => $this->fit_id,
            "fit" => new FittingResource($this->fit),
            "original_price" => $this->original_price,
            "display_price" => $this->display_price,
            "discount" => $this->discount,
            "sale_price" => $this->sale_price,
            "user" => $this->user,
            'is_archive' => $this->is_archive ? Carbon::parse($this->is_archive) : null,
            "is_ecommerce" => $this->is_ecommerce,
            "stocks_count" => $this->stocks_count,
            "stocks" => $this->stocks,
            "sizes" => $this->sizes,
            "available_size" => explode(".", trim($this->available_size, ".")),
            "available_size" => $this->available_size ? explode(".", trim($this->available_size, ".")) : [],
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}


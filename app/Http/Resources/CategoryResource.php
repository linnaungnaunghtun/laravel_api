<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CategoryResource extends JsonResource
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
            'category_name' => $this->category_name,
            'slug' => $this->slug,
            'user_id' => $this->user,
            'product_type_id' => $this->product_type_id,
            'product_type' => $this->productType,
            'fits' => FittingResource::collection($this->fits),
            'sizes' => SizeResource::collection($this->sizes),
            'products_count' => $this->products_count,
            'sizes_count' => $this->sizes_count,
            'fits_count' => $this->fits_count,
            'is_archive' => $this->is_archive ? Carbon::parse($this->is_archive) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

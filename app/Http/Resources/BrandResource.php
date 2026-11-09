<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'brand_name' => $this->brand_name,
            'slug' => $this->slug,
            'user_id' => $this->user,
            'products_count'=>$this->products_count,
            'brand_image' => $this->brand_image ? $this->brand_image : config('base.default_image'),
            'is_archive' => $this->is_archive ? Carbon::parse($this->is_archive) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

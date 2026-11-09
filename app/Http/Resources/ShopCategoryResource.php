<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->image ? $this->image : config('base.default_image'),
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
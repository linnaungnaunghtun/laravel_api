<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'desktop_ads' => $this->desktop_ads,
            'mobile_ads' => $this->mobile_ads,
            'type' => $this->type,
            'button_text' => $this->button_text,
            'link' => $this->link,
            'user_id' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

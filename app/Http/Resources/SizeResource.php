<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
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
            'size' => $this->size,
            'user_id' => $this->user,
            'category' => $this->category,
            'category_id' => $this->category_id,
            'stocks_count'=> $this->stocks_count,
            'is_archive' => $this->is_archive ? Carbon::parse($this->is_archive) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

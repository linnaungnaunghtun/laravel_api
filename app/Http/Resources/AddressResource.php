<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "address_detail"=> $this->address_detail,
            "city"=> $this->city,
            "township"=> $this->township,
            "phone"=> $this->phone,
            "note"=> $this->note,
            "is_default"=> $this->is_default,
            "is_archive"=> $this->is_archive,
            "user_id"=> $this->user_id,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}

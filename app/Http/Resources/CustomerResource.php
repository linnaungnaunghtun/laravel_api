<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "address" => $this->address,
            "phone" => $this->phone,
            "gender" => $this->gender,
            'age' => $this->age,
            "remark" => $this->remark,
            "age_range" => $this->age_range,
            "level_id" => $this->level_id,
            "level" => $this->level,
            "user_id" => $this->user_id,
            "user" => $this->user,
            "city" => $this->city,
            "is_archive" => $this->is_archive,
            "township" => $this->township,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $url = [];
        if ($request->secure()) {
            $url =  [
                'original' => secure_asset(Storage::url($this->path_name)),
                'thumbnail' => secure_asset(Storage::url("thumbnails/" . $this->path_name)),
                'preview' => secure_asset(Storage::url("previews/" . $this->path_name)),
                'large' => secure_asset(Storage::url("larges/" . $this->path_name)),
            ];
        } else {
            $url =  [
                'original' => asset(Storage::url($this->path_name)),
                'thumbnail' => asset(Storage::url("thumbnails/" . $this->path_name)),
                'preview' => asset(Storage::url("previews/" . $this->path_name)),
                'large' => asset(Storage::url("larges/" . $this->path_name)),
            ];
        }

        return [
            'id' => $this->id,
            'path_name' => $this->path_name,
            'original_name' => $this->original_name,
            'url' => $url,
            'user_id' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

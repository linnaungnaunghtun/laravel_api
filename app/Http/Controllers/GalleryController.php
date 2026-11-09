<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use App\Http\Resources\GalleryResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        $validSortColumns = ['id', 'path_name', 'original_name'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);

        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int)$limit : 5;

        $query = Gallery::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('path_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('original_name', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user');


        $galleries = $query->paginate($limit);

        $galleries->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return GalleryResource::collection($galleries);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreGalleryRequest $request)
    {
        $inputImages = $request->file('images');
        $manager = new ImageManager(new Driver());

        $images = [];

        foreach ($inputImages as $image) {
            // Store original image to MinIO
            $path = $image->store('galleries', 'minio');
            $extension = strtolower($image->getClientOriginalExtension());

            // Read file contents directly from the uploaded file
            $imageContents = file_get_contents($image->getRealPath());

            if ($extension === 'gif') {
                // Copy original GIF to each resized folder (preserve animation)
                Storage::disk('minio')->put("thumbnails/{$path}", $imageContents);
                Storage::disk('minio')->put("previews/{$path}", $imageContents);
                Storage::disk('minio')->put("larges/{$path}", $imageContents);
            } else {
                // Read the image once and clone for other sizes
                $originalImage = $manager->read($imageContents);
                $imageForThumbnail = clone $originalImage;
                $imageForPreview = clone $originalImage;
                $imageForLarge = clone $originalImage;

                // Generate and upload thumbnail (100x100 cropped)
                $thumbnail = $imageForThumbnail->cover(100, 100)->toJpeg();
                Storage::disk('minio')->put("thumbnails/{$path}", (string) $thumbnail);

                // Generate and upload preview (scaled to 700px)
                $preview = $imageForPreview->scale(700)->toJpeg();
                Storage::disk('minio')->put("previews/{$path}", (string) $preview);

                // Generate and upload large (scaled to 1280px)
                $large = $imageForLarge->scale(1280)->toJpeg();
                Storage::disk('minio')->put("larges/{$path}", (string) $large);
            }

            // Prepare metadata
            $images[] = [
                'path_name' => $path,
                'original_name' => $image->getClientOriginalName(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Insert all image records at once
        Gallery::insert($images);

        $insertedImages = Gallery::whereIn('path_name', array_column($images, 'path_name'))->get();

        return response()->json([
            'message' => 'Images uploaded successfully',
            'data' => GalleryResource::collection($insertedImages)
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:galleries,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Gallery ID'
            ], 404);
        }

        $gallery  = Gallery::find($id);

        return response()->json([
            'message' => 'Gallery retrieved successfully',
            'data' => new GalleryResource($gallery)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateGalleryRequest $request, Gallery $gallery)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:galleries,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Gallery ID'
            ], 404);
        }

        $gallery = Gallery::find($id);

        $currentImage = $gallery->path_name;

        Storage::disk('minio')->delete($currentImage);
        Storage::disk('minio')->delete("thumbnails/" . $currentImage);
        Storage::disk('minio')->delete("previews/" . $currentImage);
        Storage::disk('minio')->delete("larges/" . $currentImage);

        $gallery->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ]);
    }
}

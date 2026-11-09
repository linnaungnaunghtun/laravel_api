<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Http\Resources\SliderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        $validSortColumns = ['id'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);

        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int)$limit : 5;

        $query = Slider::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('desktop_image', 'like', '%' . $searchTerm . '%');
                $q->where('mobile_image', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user');

        $sizes = $query->paginate($limit);

        $sizes->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return SliderResource::collection($sizes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        $slider = Slider::create([
            'desktop_image' => $request->desktop_image,
            'mobile_image' => $request->mobile_image,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Slider created successfully',
            'data' => new SliderResource($slider),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sliders,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Slider ID'
            ], 404);
        }

        $slider = Slider::find($id);

        return response()->json([
            'message' => 'Slider retrieved successfully',
            'data' => new SliderResource($slider)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, $id)
    {

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sliders,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Slider ID'
            ], 404);
        }

        $slider = Slider::find($id);

        $slider->update([
            'desktop_image' => $request->desktop_image,

            'mobile_image' => $request->mobile_image,
        ]);

        return response()->json([
            'message' => 'Slider updated successfully',
            'data' => new SliderResource($slider)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sliders,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Slider ID'
            ], 404);
        }

        $slider = Slider::find($id);

        $slider->delete();

        return response()->json([
            'message' => 'Slider deleted successfully'
        ]);
    }
}

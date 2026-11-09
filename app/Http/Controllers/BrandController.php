<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        
        $validSortColumns = ['id', 'brand_name'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);

        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $query = Brand::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('brand_name', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user');
        $query->withCount('products');


        $brands = $query->paginate($limit);


        $brands->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {

        $brand = Brand::create([
            'brand_name' => $request->brand_name,
            'slug' => Str::slug($request->brand_name),
            'brand_image' => $request->brand_image,
            'is_archive' => $request->is_archive,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Brand created successfully',
            'data' => new BrandResource($brand),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:brands,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Brand ID'
            ], 404);
        }

        $query = Brand::query();
        $query->with('user');
        $query->withCount('products');
        $brand = $query->find($id);

        return response()->json([
            'message' => 'Brand retrieved successfully',
            'data' => new BrandResource($brand)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, $id)
    {


        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:brands,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Brand ID'
            ], 404);
        }

        $brand = Brand::find($id);

        $brand->update([
            'brand_name' => $request->brand_name,
            'slug' => Str::slug($request->brand_name),
            'brand_image' => $request->brand_image,
            'is_archive' => $request->is_archive,
        ]);

        return response()->json([
            'message' => 'Brand updated successfully',
            'data' => new BrandResource($brand)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:brands,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Brand ID'
            ], 404);
        }

        $brand = Brand::find($id);

        if ($brand->is_archive) {
            $brand->update([
                'is_archive' => null,
            ]);
        } else {
            $brand->update([
                'is_archive' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Brand archive successfully'
        ]);
    }
}

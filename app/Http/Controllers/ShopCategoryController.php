<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopCategoryRequest;
use App\Http\Requests\UpdateShopCategoryRequest;
use App\Http\Resources\ShopCategoryResource;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShopCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchTerm = $request->input('q');
        $validSortColumns = ['id', 'title'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);

        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $query = ShopCategory::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);
        $query->with('user');

        $shopCategories = $query->paginate($limit);

        $shopCategories->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return ShopCategoryResource::collection($shopCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopCategoryRequest $request)
    {


        $shopCategory = ShopCategory::create([
            'title' => $request->title,
            'link' => $request->link,
            'image' => $request->image,
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'message' => 'Shop Category created successfully',
            'data' => new ShopCategoryResource($shopCategory),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:shop_categories,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Shop Category ID'
            ], 404);
        }

        $query = ShopCategory::query();
        $query->with('user');
        $shopCategory = $query->find($id);

        return response()->json([
            'message' => 'Shop Category retrieved successfully',
            'data' => new ShopCategoryResource($shopCategory)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopCategoryRequest $request, $id)
    {
        $shopCategory = ShopCategory::find($id);


        if (!$shopCategory) {
            return response()->json([
                'message' => 'Invalid Shop Category ID'
            ], 404);
        }


        $data = $request->only(['title', 'link', 'image']);

        $shopCategory->update($data);

        return response()->json([
            'message' => 'Shop Category updated successfully',
            'data' => new ShopCategoryResource($shopCategory)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:shop_categories,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Shop Category ID'
            ], 404);
        }

        $shopCategory = ShopCategory::find($id);
        $shopCategory->delete();

        return response()->json([
            'message' => 'Shop Category deleted successfully'
        ]);
    }
}

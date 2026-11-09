<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Fit;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Step 1: Initialize the base query
        $query = Category::query();


        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('category_name', 'like', '%' . $searchTerm . '%');
            });
        }

        // FILTER FUNCTIONALITY

        $filterBy = $request->input('filter_by');
        $filterVal = $request->input('filter_val');

        if ($filterBy && $filterVal) {
            $query->where($filterBy, $filterVal);
        }


        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'category_name'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);


        // LOAD RELATIONSHIPS AND COUNTS

        $query->with('fits', 'sizes', 'productType', 'user');
        $query->withCount('products', 'fits', 'sizes');


        // PAGINATION

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $categories = $query->paginate($limit);


        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $categories->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'filter_by' => $filterBy,
            'filter_val' => $filterVal,
        ]);


        // RETURN RESULTS

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        try {
            DB::beginTransaction();
            $category = Category::create([
                'category_name' => $request->category_name,
                'slug' => Str::slug($request->category_name),
                'product_type_id' => $request->product_type_id,
                'is_archive' => $request->is_archive,
                'user_id' => auth()->id()
            ]);


            // multiple size insertion
            $sizesStringToArray = explode(',', $request->sizes);

            $sizes = [];
            foreach ($sizesStringToArray as $size) {
                $sizes[] = [
                    'size' => trim($size),
                    'category_id' => $category->id,
                    'is_archive' => $request->is_archive,
                    'user_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Size::insert($sizes);


            // multiple fitting insertion

            if ($request->fits) {

                $fittingsStringToArray = explode(',', trim($request->fits));
                $fittings = [];
                foreach ($fittingsStringToArray as $fitting) {
                    $fittings[] = [
                        'name' => trim($fitting),
                        'category_id' => $category->id,
                        'is_archive' => $request->is_archive,
                        'user_id' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                Fit::insert($fittings);
            }


            DB::commit();

            return response()->json([
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category),
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Category ID'
            ], 404);
        }



        $query = Category::query();
        $query->with('fits', 'sizes', 'productType', 'user');
        $query->withCount('products', 'fits', 'sizes');
        $category = $query->find($id);




        return response()->json([
            'message' => 'Category retrieved successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Category ID'
            ], 404);
        }

        $category = Category::find($id);
        $category->update([
            'category_name' => $request->category_name,
            'slug' => Str::slug($request->category_name),
            'product_type_id' => $request->product_type_id,
            'is_archive' => $request->is_archive
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Category ID'
            ], 404);
        }

        $category = Category::find($id);


        if ($category->is_archive) {
            $category->update([
                'is_archive' => null,
            ]);
        } else {
            $category->update([
                'is_archive' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Product Category archive successfully'
        ]);
    }
}

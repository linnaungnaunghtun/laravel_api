<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;
use App\Http\Resources\ProductTypeResource;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        $validSortColumns = ['id', 'type'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);

        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $query = ProductType::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('type', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);


        $query->with('user', 'categories');
        $query->withCount('products');


        $productTypes = $query->paginate($limit);

        $productTypes->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return ProductTypeResource::collection($productTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductTypeRequest $request)
    {
        $productType = ProductType::create([

            'type' => $request->type,
            'is_archive' => $request->is_archive,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Product-Type created successfully',
            'data' => new ProductTypeResource($productType),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:product_types,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Type ID'
            ], 404);
        }

        $query = ProductType::query();
        $query->with('user', 'categories');
        $query->withCount('products');
        $productType = $query->find($id);


        return response()->json([
            'message' => 'Product-Type retrieved successfully',
            'data' => new ProductTypeResource($productType)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductTypeRequest $request, $id)
    {

        $productType = ProductType::find($id);

        if (!$productType) {
            return response()->json([
                'message' => 'Invalid Product Type ID'
            ], 404);
        }

        // Update the model with the request data
        $productType->update($request->only([
            'type',
            'is_archive'
        ]));

        return response()->json([
            'message' => 'Product Type updated successfully',
            'data' => new ProductTypeResource($productType)
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $validated = Validator::make(['id' => $productType->id], [
            'id' => 'required|integer|exists:product_types,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Product Type ID'
            ], 404);
        }

        if ($productType->is_archive) {
            $productType->update([
                'is_archive' => null,
            ]);
        } else {
            $productType->update([
                'is_archive' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Product Type archive successfully'
        ]);
    }
}

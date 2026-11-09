<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // INITIALIZE BASE QUERY
        $query = Product::query();

        if ($request->has("less_stock_product_count")) {
            $count = $query->where('stocks_count', '<=', $request->less_stock_product_count)->count();
            return response()->json([
                'less_stock_product_count' => $count,
            ]);
        }


        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('product_code', 'like', '%' . $searchTerm . '%');
                // Uncomment the line below if you want to include 'gender' in the search
                // ->orWhere('gender', 'like', '%' . $searchTerm . '%');
            });
        }


        // FILTER FUNCTIONALITY

        $filterBy = $request->input('filter_by');
        $filterVal = $request->input('filter_val');

        if ($filterBy && $filterVal) {
            $query->where($filterBy, $filterVal);
        }


        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'product_name', 'product_code', 'gender', 'stocks_count', 'original_price', 'display_price', 'discount', 'sale_price', 'is_ecommerce'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);


        // LOAD RELATIONSHIPS AND COUNTS

        $query->with('user', 'category', 'productType', 'fit', 'brand', 'productImages', 'stocks', 'sizes');
        // $query->withCount('stocks');


        // PAGINATION

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $products = $query->paginate($limit);


        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $products->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'filter_by' => $filterBy,
            'filter_val' => $filterVal,
        ]);


        // RETURN RESULTS

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        $productCodeToUpperCase = strtoupper($request->product_code);
        $discount = $request->discount ?? 0;
        $salePrice = $request->display_price - $discount;
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_code' => $productCodeToUpperCase,
            'slug' => Str::slug($request->product_name . " " . $productCodeToUpperCase),
            'description' => $request->description,
            'gender' => $request->gender,
            'brand_id' => $request->brand_id,
            'product_type_id' => $request->product_type_id,
            'category_id' => $request->category_id,
            'fit_id' => $request->fit_id,
            'original_price' => $request->original_price,
            'display_price' => $request->display_price,
            'discount' => $discount,
            'sale_price' => $salePrice,
            'is_archive' => $request->is_archive,
            "is_ecommerce" => $request->is_ecommerce ?? 1,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:products,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Product ID'
            ], 404);
        }

        $product = Product::find($id);

        return response()->json([
            "message" => "Product retrieved successfully",
            "data" => new ProductResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {

        $productCodeToUpperCase = strtoupper($request->product_code);
        $discount = $request->discount ?? 0;
        $salePrice = $request->display_price - $discount;

        $product = Product::find($id);

        $product->update([
            'product_name' => $request->product_name,
            'product_code' => $productCodeToUpperCase,
            'slug' => Str::slug($request->product_name . " " . $productCodeToUpperCase),
            'description' => $request->description,
            'gender' => $request->gender,
            'brand_id' => $request->brand_id,
            'product_type_id' => $request->product_type_id,
            'category_id' => $request->category_id,
            'fit_id' => $request->fit_id,
            'original_price' => $request->original_price,
            'display_price' => $request->display_price,
            'discount' => $discount,
            'sale_price' => $salePrice,
            'is_archive' => $request->is_archive,
            "is_ecommerce" => $request->is_ecommerce ?? 1,
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:products,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Product ID'
            ], 404);
        }

        $product = Product::find($id);

        if ($product->is_archive) {
            $product->update([
                'is_archive' => null,
            ]);
            return response()->json([
                'message' => 'Product restore successfully'
            ]);
        }

        $product->update([
            'is_archive' => now(),
        ]);

        return response()->json([
            'message' => 'Product archive successfully'
        ]);
    }
}

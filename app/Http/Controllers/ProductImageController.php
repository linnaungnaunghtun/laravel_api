<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Resources\ProductImageResource;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productImages = ProductImage::where('product_id', $request->product_id)->get();
        return ProductImageResource::collection($productImages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductImageRequest $request)
    {
        $productImages = [];
        foreach ($request->product_images as $product_image) {
            $productImages[] = ProductImage::create(
                [
                    'product_id' => $request->product_id,
                    'path_name' => $product_image['path_name'],
                    'original_name' => $product_image['original_name'],
                    'user_id' => auth()->id(),
                ]
            );
        }

        // $productImages = ProductImage::where('product_id', $request->product_id)->get();
        return response()->json([
            'message' => 'ProductImage created successfully',
            'data' => ProductImageResource::collection($productImages),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:product_images,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid ProductImage ID'
            ], 404);
        }

        $productImage = ProductImage::find($id);
        $productImage->delete();

        return response()->json([
            "message" => "ProductImage deleted successfully",
        ]);
    }
}

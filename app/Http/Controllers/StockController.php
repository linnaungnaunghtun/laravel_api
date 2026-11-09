<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Resources\StockResource;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // INITIALIZE BASE QUERY

        $query = Stock::query();


        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('shop_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('barcode', 'like', '%' . $searchTerm . '%')
                    ->orWhere('is_sold', 'like', '%' . $searchTerm . '%');
            });
        }


        // FILTER FUNCTIONALITY

        $filterBy = $request->input('filter_by');
        $filterVal = $request->input('filter_val');

        if ($filterBy && $filterVal) {
            $query->where($filterBy, $filterVal);
        }


        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'product_id', 'shop_code', 'barcode', 'size_id', 'is_sold'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);


        // LOAD RELATIONSHIPS

        $query->with('user', 'product', 'size');


        // PAGINATION

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $stocks = $query->paginate($limit);


        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $stocks->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'filter_by' => $filterBy,
            'filter_val' => $filterVal,
        ]);


        // RETURN RESULTS

        return StockResource::collection($stocks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $shopCodeToUpperCase = strtoupper($request->shop_code);
        $shopCodeRemoveSpace = str_replace(' ', '', $shopCodeToUpperCase);

        $barCodeToUpperCase = strtoupper($request->barcode);
        $barCodeRemoveSpace = str_replace(' ', '', $barCodeToUpperCase);


        $stock = Stock::create([
            'product_id' => $request->product_id,
            'shop_code' => $shopCodeRemoveSpace,
            'barcode' => $barCodeRemoveSpace,
            'size_id' => $request->size_id,
            'is_sold' => $request->is_sold,
            'user_id' => auth()->id()
        ]);

        // update stocks_count form product

        $product = Product::withCount(['stocks as sc'])->find($request->product_id);

        $product->update(["stocks_count" => $product->sc]);


        return response()->json([
            'message' => 'Stock created successfully',
            'data' => new StockResource($stock),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|exists:stocks,id',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Stock ID',
            ], 404);
        }
        $stock = Stock::find($id);
        return response()->json([
            'message' => 'Stock retrieved successfully',
            'data' => new StockResource($stock),
        ]);
    }

    public function showWithBarcode($barcode)
    {
        $validated = Validator::make(['barcode' => $barcode], [
            'barcode' => 'required|exists:stocks,barcode',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid barcode',
            ], 404);
        }
        $stock = Stock::where('barcode', $barcode)->with('product', 'size')->first();
        return response()->json([
            'message' => 'Stock retrieved successfully',
            'data' => new StockResource($stock),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, $id)
    {
        $shopCodeToUpperCase = strtoupper($request->shop_code);
        $shopCodeRemoveSpace = str_replace(' ', '', $shopCodeToUpperCase);

        $barCodeToUpperCase = strtoupper($request->barcode);
        $barCodeRemoveSpace = str_replace(' ', '', $barCodeToUpperCase);

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:stocks,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Stock ID'
            ], 404);
        }

        $stock = Stock::find($id);

        $stock->update([
            'product_id' => $request->product_id,
            'shop_code' => $shopCodeRemoveSpace,
            'barcode' => $barCodeRemoveSpace,
            'size_id' => $request->size_id,
            'is_sold' => $request->is_sold,
        ]);

        return response()->json([
            'message' => 'Stock updated successfully',
            'data' => new StockResource($stock),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|exists:stocks,id',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Stock ID',
            ], 404);
        }

        $stock = Stock::with('user', 'product', 'size')->find($id);

        $productId = $stock->product_id;

        $stock->delete();

        // update stocks_count form product

        $product = Product::withCount(['stocks as sc'])->find($productId);

        $product->update(["stocks_count" => $product->sc]);

        return response()->json([
            'message' => 'Stock deleted successfully',

        ]);
    }

    public function stockCheck(Request $request)
    {
        $stocks = Stock::where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)->get();

        if (count($stocks) == 0) {
            return response()->json([], 404);
        }
        return response()->json(StockResource::collection($stocks));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm       = $request->input('q');
        $validSortColumns = ['order_id', 'product_id', 'stock_id', 'is_sold'];
        $sortBy           = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection    = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit            = $request->input('limit', 5);
        $limit            = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;
        $query            = OrderItem::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('order_id', 'like', '%' . $searchTerm . '%');
                $q->orWhere('product_id', 'like', '%' . $searchTerm . '%');
                $q->orWhere('stock_id', 'like', '%' . $searchTerm . '%');
                $q->orWhere('is_sold', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user');

        $orderItem = $query->paginate($limit);

        $orderItem->appends([
            'q'              => $searchTerm,
            'sort_by'        => $sortBy,
            'sort_direction' => $sortDirection,
            'limit'          => $limit,
        ]);

        return OrderItemResource::collection($orderItem);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:order_items,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid OrderItem ID',
            ], 404);
        }

        $orderItem = OrderItem::find($id);
        $orderItem->delete();

        return response()->json([
            "message" => "OrderItem deleted successfully",
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderConfirmRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Voucher;
use App\Models\VoucherItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm       = $request->input('q');
        $validSortColumns = ['item_count', 'total', 'discount', 'coupon_code', 'status'];
        $sortBy           = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection    = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit            = $request->input('limit', 5);
        $limit            = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;
        $query            = Order::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('item_count', 'like', '%' . $searchTerm . '%');
                $q->orWhere('total', 'like', '%' . $searchTerm . '%');
                $q->orWhere('discount', 'like', '%' . $searchTerm . '%');
                $q->orWhere('coupon_code', 'like', '%' . $searchTerm . '%');
                $q->orWhere('status', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user', 'address', 'coupon', 'orderItems');

        $order = $query->paginate($limit);

        $order->appends([
            'q'              => $searchTerm,
            'sort_by'        => $sortBy,
            'sort_direction' => $sortDirection,
            'limit'          => $limit,
        ]);

        return OrderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:orders,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Order ID',
            ], 404);
        }

        $order = Order::find($id);


        return response()->json([
            'message' => 'Voucher updated successfully',
            'data'    => new OrderResource($order),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:orders,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Order ID',
            ], 404);
        }

        $order = Order::find($id);
        $order->update([
            "item_count" => $request->item_count,
            "total" => $request->total,
            "discount" => $request->discount,
            "coupon_code" => $request->coupon_code,
            "status" => $request->status,
            "cancel_message" => $request->cancel_message,
            "cancel_user_id" => $request->cancel_user_id
        ]);

        return response()->json([
            'message' => 'Voucher updated successfully',
            'data'    => new OrderResource($order),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:orders,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Order ID',
            ], 404);
        }

        $order = Order::find($id);
        $order->delete();

        return response()->json([
            "message" => "Order deleted successfully",
        ]);
    }


    public function orderConfirm(OrderConfirmRequest $request)
    {


        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the order
            $order = Order::findOrFail($request->order_id);

            // Check if the order status is as expected
            if ($order->status === config("base.order_status")[0]) {
                // Update the order status and delivery date range
                $order->status = config("base.order_status")[1];
                $order->delivery_date_range = $request->start_date . " , " . $request->end_date;
                $order->save();

                // Update the selected stocks
                foreach ($request->selected_stocks as $selectedStock) {
                    $currentOrderItem = OrderItem::findOrFail($selectedStock['order_item_id']);
                    $currentOrderItem->barcode = $selectedStock['barcode'];
                    $currentOrderItem->stock_id = $selectedStock['stock_id'];
                    $currentOrderItem->save();
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                "message" => "Order confirmed successfully",
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            return response()->json([
                "message" => "Order confirmation failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function orderDeliver(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if ($order->status !== config("base.order_status")[1]) {
            return response()->json([
                "message" => "Order confirm first",
            ], 403);
        }

        $order->status = config("base.order_status")[2];
        $order->update();

        return response()->json([
            "message" => "Order is delivering successfully",
        ]);
    }

    public function orderComplete(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if ($order->status !== config("base.order_status")[2]) {
            return response()->json([
                "message" => "Deliver order first",
            ], 403);
        }

        try {
            DB::beginTransaction();

            $voucher = Voucher::create([
                "cash_discount"           => $order->coupon_discount_amount,
                "customer_id"             => $order->user->customer->id,
                "discount_percent_amount" => $order->level_discount_amount,
                "discount_percentage"     => $order->level_discount_percentage,
                "net_total"               => $order->net_total,
                "payment_method"          => "wallet",
                "sale_type"               => "online",
                "tax"                     =>  0,
                "tax_amount"              =>  0,
                "total"                   => $order->total,
                "voucher_date"            => $order->voucher_date ?? now(),
                "voucher_no"              => $order->order_id,
                "user_id"                 => auth()->id(),

                "created_at"              => now(),
                "updated_at"              => now(),
            ]);

            // create voucher item

            $items = [];

            foreach ($order->orderItems as $item) {

                $item    = (object) $item;
                $product = (object) $item->product;

                $items[] = [
                    "voucher_id"     => $voucher->id,
                    "product_id"     => $item->product_id,
                    "product_name"   => $item->product_name,
                    "product_code"   => $item->product_code,
                    "barcode"        => $item->barcode,
                    "size_name"      => $item->size_name,
                    "size_id"        => $item->size_id,
                    "original_price" => $product->original_price,
                    "display_price"  => $item->display_price,
                    "discount"       => $item->discount,
                    "sale_price"     => $item->sale_price,
                    "profit"         => $item->sale_price - $product->original_price,
                    "user_id"        => auth()->id(),
                    "voucher_id_code" => $voucher->voucher_no,
                    "customer_name" => $voucher->customer->name ?? '',
                    "customer_phone" => $voucher->customer->phone ?? '',
                    "customer_id" => $voucher->customer_id,
                    "sale_type" => $voucher->sale_type,
                    "brand_name" => $product->brand->brand_name ?? '',
                    "brand_id" => $product->brand_id ?? '',
                    "category_name" => $product->category->category_name ?? '',
                    "category_id" => $product->category_id ?? '',
                    "fit_name" => $product->fit->name ?? '',
                    "fit_id" => $product->fit_id ?? '',
                    "created_at"     => now(),
                    "updated_at"     => now(),
                ];
            }

            VoucherItem::insert($items);

            foreach ($order->orderItems as $orderItem) {
                $orderItem->sold = true;
                $orderItem->update();
            }

            $voucher->net_profit = array_reduce($items, function ($carry, $item) {
                $item = (object) $item;
                return $carry + $item->profit;
            }, 0) - ($voucher->discount_percent_amount + $voucher->cash_discount + $voucher->tax_amount);

            $voucher->save();

            // remove stocks from stock

            Stock::whereIn("barcode", collect($order->orderItems)->pluck('barcode'))->get()->each->delete();

            // update stocks_count form product
            // $productIds = collect($order->orderItems)->pluck('product_id');
            // $products   = Product::whereIn('id', $productIds)->withCount(['stocks as sc'])->get();
            // foreach ($products as $product) {
            //     $product->update(['stocks_count' => $product->sc]);
            // }

            $order->status = config("base.order_status")[3];
            $order->voucher_id = $voucher->id;
            $order->update();

            DB::commit();

            return response()->json([
                'message' => 'Voucher created successfully',
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function orderCancel(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if ($order->status === config("base.order_status")[3]) {
            return response()->json([
                "message" => "You can't cancel completed order",
            ], 403);
        }

        $order->is_cancel = true;
        $order->cancel_message = $request->cancel_message;
        $order->cancel_user_id = Auth::id();
        $order->update();

        foreach ($order->orderItems as $orderItem) {
            $orderItem->sold = true;
            $orderItem->update();
        }

        return response()->json([
            "message" => "Order is cancel",
        ]);
    }

    public function orderCount(Request $request)
    {
        $count = Order::where("status", $request->status)->where("is_cancel", 0)->count();
        return response()->json([
            "data" => $count,
        ]);
    }
}

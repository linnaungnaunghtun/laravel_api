<?php

namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\ECommerceOrderResource;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ECommerceOrderController extends Controller
{
    public function generateOrderId()
    {
        // Generate a random number
        $randomNumber = mt_rand(10000, 99999);

        // Generate a random string of uppercase letters
        $randomLetters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);

        // Combine them into an order ID without dashes
        $orderId = "ORDER" . $randomNumber . $randomLetters;

        return $orderId;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())->with("address", "orderItems")->latest("id")->get();
        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data'    => $orders,
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        // return $request;
        // Begin a database transaction
        DB::beginTransaction();

        try {

            $levelDiscountPercentage = Auth::user()->customer->level->discount;
            $itemsFromRequest = collect($request->items);
            $itemCount = count($request->items);
            $orderedProducts = Product::whereIn("id", $itemsFromRequest->pluck("id"))->get();


            // Fetch coupon details from the coupons table
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            $couponDiscountPercentage = $coupon ? $coupon->discount : 0;

            // Calculate total, discounts, and net total
            $total = $orderedProducts->sum("sale_price");

            // Calculate level discount amount
            $levelDiscountAmount = ($total * $levelDiscountPercentage) / 100;

            // Calculate coupon discount amount
            $couponDiscountAmount = ($total * $couponDiscountPercentage) / 100;

            // Calculate net total
            $netTotal = $total - ($levelDiscountAmount + $couponDiscountAmount);

            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(), // Assuming the user is authenticated
                'address_id' => $request->address_id,
                'item_count' => $itemCount,
                'total' => $total,
                'net_total' => $netTotal,
                'level_discount_percentage' => $levelDiscountPercentage,
                'level_discount_amount' => $levelDiscountAmount,
                'coupon_discount_amount' => $couponDiscountAmount,
                'coupon_discount_percentage' => $couponDiscountPercentage,
                'coupon_code' => $request->coupon_code,
                'status' => 'pending',
                'order_id' => $this->generateOrderId(),
            ]);


            // Create order items
            $orderItems = [];

            foreach ($request->items as $el) {
                $el = (object) $el;
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $el->id,
                    'user_id' => Auth::id(),
                    'product_name' => $el->product_name,
                    'product_code' => $el->product_code,
                    'product_image' => $el->image ?? null,
                    'product_slug' => $el->slug,
                    'size_id' => $el->size_id,
                    'size_name' => $el->size_name,
                    'display_price' => $orderedProducts->find($el->id)->display_price,
                    'discount' => $orderedProducts->find($el->id)->discount,
                    'sale_price' => $orderedProducts->find($el->id)->sale_price,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];
            };

            OrderItem::insert($orderItems);


            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Return an error response
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::where("order_id", $id)->where('user_id', Auth::id())->with("address", "coupon", "orderItems", "user")->first();

        if (!$order) {
            return response()->json([
                'message' => 'Invalid Order Code',
            ], 404);
        }

        return response()->json([
            'message' => 'Order retrieved successfully',
            'data'    =>  new ECommerceOrderResource($order),
        ]);
    }

    public function orderCancel(Request $request)
    {
        $order = Order::where("order_id", $request->order_id)->where('user_id', Auth::id())->where("status", "pending")->first();

        if (!$order) {
            return response()->json([
                'message' => 'Invalid Order Code',
            ], 404);
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
            "message" => "Your order is canceled successfully",
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

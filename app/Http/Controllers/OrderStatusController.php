<?php
namespace App\Http\Controllers;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderStatusController extends Controller
{
    public function orderStatus(ChangeOrderStatusRequest $request)
    {
        $order = Order::find($request->order_id);

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Order status changed successfully',
            'data'    => new OrderResource($order)]);
    }
}

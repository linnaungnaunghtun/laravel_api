<?php
namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $carts = Cart::where('user_id', auth()->id())->get();

        return response()->json([
            'message' => 'Carts data retrieved successfully',
            'data'    => CartResource::collection($carts),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $cart = Cart::create([
            'product_id' => $request->product_id,
            'stock_id'   => $request->stock_id,
            'user_id'    => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Cart created successfully',
            'data'    => new CartResource($cart),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:carts,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Cart ID',
            ], 404);
        }

        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $cart) {
            return response()->json([
                'message' => 'Unauthorized or Cart item not found',
            ], 403);
        }

        return response()->json([
            "message" => "Cart retrieved successfully",
            "data"    => new CartResource($cart),
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, $id)
    {
        $cart = Cart::find($id);

        if (! $cart) {
            return response()->json([
                'message' => 'Invalid Cart ID',
            ], 404);
        }

        // Ensure the wishlist item belongs to the logged-in user
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update the model with the request data
        $cart->update($request->only([
            'product_id',
            'stock_id',
        ]));

        return response()->json([
            'message' => 'Cart updated successfully',
            'data'    => new CartResource($cart),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:carts,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Cart ID',
            ], 404);
        }
        $cart = Cart::find($id);

        // Ensure the wishlist item belongs to the logged-in user
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json([
            'message' => 'Cart deleted successfully',
        ]);
    }
}

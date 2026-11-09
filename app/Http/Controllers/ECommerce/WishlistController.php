<?php
namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wishlists = Wishlist::where('user_id', auth()->id())->get();

        return response()->json([
            'message' => 'Wishlists data retrieved successfully',
            'data'    => WishlistResource::collection($wishlists),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wishlist = Wishlist::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Wishlist created successfully',
            'data'    => new WishlistResource($wishlist),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:wishlists,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Wishlist ID',
            ], 404);
        }

        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $wishlist) {
            return response()->json([
                'message' => 'Unauthorized or Wishlist item not found',
            ], 403);
        }

        return response()->json([
            "message" => "Wishlist retrieved successfully",
            "data"    => new WishlistResource($wishlist),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWishlistRequest $request, $id)
    {
        $wishlist = Wishlist::find($id);

        if (! $wishlist) {
            return response()->json([
                'message' => 'Invalid Wishlist ID',
            ], 404);
        }

        // Ensure the wishlist item belongs to the logged-in user
        if ($wishlist->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update the model with the request data
        $wishlist->update($request->only([
            'product_id',
        ]));

        return response()->json([
            'message' => 'Wishlist updated successfully',
            'data'    => new WishlistResource($wishlist),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:wishlists,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Wishlist ID',
            ], 404);
        }
        $wishlist = Wishlist::find($id);

        // Ensure the wishlist item belongs to the logged-in user
        if ($wishlist->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $wishlist->delete();

        return response()->json([
            'message' => 'Wishlist deleted successfully',
        ]);
    }
}

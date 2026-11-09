<?php

namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ECommerceReviewResource;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    public function index(Request $request)

    {
        $reviews = Review::where('product_id', $request->product_id)->with('user')->get();
        return ECommerceReviewResource::collection($reviews);
    }

    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'product_id' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,
            'is_show' => 0,
            'user_id' => auth()->id(),
        ]);
        return response()->json([
            'message' => 'Review created successfully',
            'data' => new ECommerceReviewResource($review)
        ]);


    }

    public function update(UpdateReviewRequest $request, $id)
    {
        $review = Review::find($id);
        if (! $review) {
            return response()->json([
                'message' => 'Invalid Review ID',
            ], 404);
        }

        if ($review->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $review->update([
            "review" => $request->review,
            "rating" => $request->rating,
        ]);

        return response()->json([
            'message' => 'Review updated successfully',
            'data'    => new ECommerceReviewResource($review),
        ]);

    }


    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:reviews,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Review ID',
            ], 404);
        }

        $review = Review::find($id);


        if ($review->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ReviewManageController extends Controller
{


    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        $validSortColumns = ['id', 'review','rating'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int)$limit : 5;
        $query = Review::query();
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('review', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('product', function ($q) use ($searchTerm) {
                        $q->where('product_name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }
        $query->orderBy($sortBy, $sortDirection);
        $query->with('user', 'product');
        $reviews = $query->paginate($limit);
        $reviews->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return ReviewResource::collection($reviews);
    }





    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:reviews,id',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Review ID'
            ], 404);
        }
        $review = Review::with('user', 'product')->find($id);
        return response()->json([
            'message' => 'Review retrieved successfully',
            'data' => new ReviewResource($review)
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

        $review->update($request->only([
            'product_id',
            'review',
            'rating',
            'is_show',
        ]));
        return response()->json([
            'message' => 'Review updated successfully',
            'data'    => new ReviewResource($review),
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

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
        ]);
    }

  
     public function updateIsPublish($id)
    {

        // Validate the provided service ID to ensure it exists in the 'reviews' table
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:reviews,id',
        ]);

        // If validation fails, respond with a 404 error
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Review ID'
            ], 404);
        }

        // Retrieve the review instance by ID
        $review = Review::find($id);

        // Update only the 'is_show' status using data from the request
        $review->update([
            'is_show' => !$review->is_show,
        ]);

        // Return a success message along with the updated review resource
        return response()->json([
            'message' => 'Review updated successfully',
            'data' => new ReviewResource($review),
        ]);
    }


    public function reviewCount(Request $request)
    {
        $count = Review::where("is_show", $request->is_show)
            ->whereDate("created_at", today())  // Changed to created_at and using whereDate
            ->count();

        return response()->json([
            "data" => $count,
        ]);
    }
}


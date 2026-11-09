<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $searchTerm = $request->input('q');
        $validSortColumns = ["id", 'title', 'code', 'discount', 'expire_date'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $query = Coupon::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('discount', 'like', '%' . $searchTerm . '%')
                    ->orWhere('expire_date', 'like', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user');

        $coupon = $query->paginate($limit);

        $coupon->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        // return CouponResource::collection($coupon);
        return response()->json([
            "message" => "Coupon retrieved successfully",
            "data" => CouponResource::collection($coupon)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {

        // modified coupon
        $couponCodeToUpperCase = strtoupper($request->code);
        $couponCodeRemoveSpace = str_replace(' ', '', $couponCodeToUpperCase);

        $coupon = Coupon::create([
            'title' => $request->title,
            'code' => $couponCodeRemoveSpace,
            'discount' => $request->discount,
            'expire_date' => $request->expire_date,
            'is_archive' => $request->is_archive,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Coupon created successfully',
            'data' => new CouponResource($coupon),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:coupons,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Coupon ID'
            ], 404);
        }

        $coupon = Coupon::find($id);

        return response()->json([
            "message" => "Coupon retrieved successfully",
            "data" => new CouponResource($coupon)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, $id)
    {

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:coupons,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Coupon ID'
            ], 404);
        }

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'message' => 'Invalid Coupon ID'
            ], 404);
        }

        $coupon->update(array_merge(
            $request->only([
                'title',
                'discount',
                'expire_date',
                'is_archive'
            ]),
            ['code' => strtoupper($request->code)]
        ));

        return response()->json([
            'message' => 'Coupon updated successfully',
            'data' => new CouponResource($coupon)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:coupons,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Coupon ID'
            ], 404);
        }

        $coupon = Coupon::find($id);

        if ($coupon->is_archive) {
            $coupon->update([
                'is_archive' => null,
            ]);
            return response()->json([
                'message' => 'Coupon restore successfully'
            ]);
        }

        $coupon->update([
            'is_archive' => now(),
        ]);

        return response()->json([
            'message' => 'Coupon archive successfully'
        ]);
    }
}

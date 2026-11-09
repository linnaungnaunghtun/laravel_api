<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchTerm = $request->input('q');
        $validSortColumns = ['id', 'desktop_ads', 'mobile_ads', 'type'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int)$limit : 5;
        $query = Banner::query();
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('desktop_ads', 'like', '%' . $searchTerm . '%')
                    ->orWhere('mobile_ads', 'like', '%' . $searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $searchTerm . '%');
            });
        }
        $query->orderBy($sortBy, $sortDirection);
        $query->with('user');
        $banners = $query->paginate($limit);
        $banners->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);
        return BannerResource::collection($banners);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $banners = Banner::create([
            'desktop_ads' => $request->desktop_ads,
            'mobile_ads' => $request->mobile_ads,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'link' => $request->link,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Banner created successfully',
            'data' => new BannerResource($banners),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:banners,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Banner ID'
            ], 404);
        }

        $banners = Banner::find($id);

        return response()->json([
            'message' => 'Banner retrieved successfully',
            'data' => new BannerResource($banners)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:banners,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Banner ID'
            ], 404);
        }

        $banner = Banner::find($id);
        $banner->update([
            'desktop_ads' => $request->desktop_ads,
            'mobile_ads' => $request->mobile_ads,
            'button_text' => $request->button_text,
            'link' => $request->link,
            'type' => $request->type
        ]);

        return response()->json([
            'message' => 'Banner updated successfully',
            'data' => new BannerResource($banner)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:banners,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Banner ID'
            ], 404);
        }

        $banner = Banner::find($id);

        $banner->delete();

        return response()->json([
            'message' => 'Banner deleted successfully'
        ]);
    }
}

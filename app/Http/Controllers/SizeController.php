<?php

namespace App\Http\Controllers;


use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Resources\SizeResource;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // INITIALIZE BASE QUERY

        $query = Size::query();


        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('size', 'like', '%' . $searchTerm . '%');
            });
        }


        // FILTER FUNCTIONALITY

        $filterBy = $request->input('filter_by');
        $filterVal = $request->input('filter_val');

        if ($filterBy && $filterVal) {
            $query->where($filterBy, $filterVal);
        }


        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'size'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);


        // LOAD RELATIONSHIPS AND COUNTS

        $query->with('user', 'category');
        $query->withCount('stocks');


        // PAGINATION

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $sizes = $query->paginate($limit);


        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $sizes->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'filter_by' => $filterBy,
            'filter_val' => $filterVal,
        ]);


        // RETURN RESULTS

        return SizeResource::collection($sizes);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        $size = Size::create([
            'size' => $request->size,
            'category_id' => $request->category_id,
            'is_archive' => $request->is_archive,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Size created successfully',
            'data' => new SizeResource($size),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sizes,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Size ID'
            ], 404);
        }

        $query = Size::query();
        $query->with('user', 'category');
        $query->withCount('stocks');
        $size = $query->find($id);


        return response()->json([
            'message' => 'Size retrieved successfully',
            'data' => new SizeResource($size)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, $id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'message' => 'Invalid Size ID'
            ], 404);
        }

        // Update the model with the request data
        $size->update($request->only([
            'size',
            'category_id',
            'is_archive',
        ]));

        return response()->json([
            'message' => 'Size updated successfully',
            'data' => new SizeResource($size)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sizes,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Size ID'
            ], 404);
        }

        $size = Size::find($id);

        if ($size->is_archive) {
            $size->update([
                'is_archive' => null,
            ]);
        } else {
            $size->update([
                'is_archive' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Size archive successfully'
        ]);
    }
}

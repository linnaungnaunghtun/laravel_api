<?php

namespace App\Http\Controllers;

use App\Http\Resources\FittingResource;
use App\Models\Fit;
use App\Http\Requests\StoreFitRequest;
use App\Http\Requests\UpdateFitRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // INITIALIZE BASE QUERY

        $query = Fit::query();


        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }


        // FILTER FUNCTIONALITY

        $filterBy = $request->input('filter_by');
        $filterVal = $request->input('filter_val');
        $validFilterColumns = ['id', 'name', 'user_id', 'category_id']; // Add other valid columns as needed

        if ($filterBy && $filterVal && in_array($filterBy, $validFilterColumns, true)) {
            $query->where($filterBy, $filterVal);
        }


        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'name'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);


        // LOAD RELATIONSHIPS AND COUNTS

        $query->with('user', 'category');
        $query->withCount('products');


        // PAGINATION

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $fit = $query->paginate($limit);


        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $fit->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'filter_by' => $filterBy,
            'filter_val' => $filterVal,
        ]);


        // RETURN RESULTS

        return FittingResource::collection($fit);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFitRequest $request)
    {
        $fit = Fit::create([
            "name" => $request->name,
            "category_id" => $request->category_id,
            'is_archive' => $request->is_archive,
            "user_id" => auth()->id()
        ]);

        return response()->json([
            'message' => 'Fitting created successfully',
            'data' => new FittingResource($fit)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:fits,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Fitting ID'
            ], 404);
        }


        $query = Fit::query();
        $query->with('user', 'category');
        $query->withCount('products');
        $fit = $query->find($id);


        return response()->json([
            'message' => 'Fitting retrieved successfully',
            'data' => new FittingResource($fit)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFitRequest $request, $id)
    {
        $fit = Fit::find($id);

        if (!$fit) {
            return response()->json([
                'message' => 'Invalid Fitting ID'
            ], 404);
        }

        // Update the model with the request data
        $fit->update($request->only([
            'name',
            'category_id',
            'is_archive'
        ]));

        return response()->json([
            'message' => 'Fitting updated successfully',
            'data' => new FittingResource($fit),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:fits,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Fitting ID'
            ], 404);
        }

        $fit = Fit::find($id);

        if ($fit->is_archive) {
            $fit->update([
                'is_archive' => null,
            ]);
        } else {
            $fit->update([
                'is_archive' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Fitting archive successfully'
        ]);
    }
}

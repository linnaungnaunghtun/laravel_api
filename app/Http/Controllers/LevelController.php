<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Http\Resources\LevelResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { {
            $searchTerm = $request->input('q');
            $validSortColumns = ['id', 'level', 'discount'];
            $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
            $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
            $limit = $request->input('limit', 5);

            $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

            $query = Level::query();

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('level', 'like', '%' . $searchTerm . '%')
                        ->orWhere('discount', 'like', '%' . $searchTerm . '%');
                });
            }

            $query->orderBy($sortBy, $sortDirection);

            $query->with('user');
            $query->withCount('customers');



            $level = $query->paginate($limit);

            $level->appends([
                'q' => $searchTerm,
                'sort_by' => $sortBy,
                'sort_direction' => $sortDirection,
                'limit' => $limit,
            ]);

            return LevelResource::collection($level);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request)
    {
        $level = Level::create([
            'level' => $request->level,
            'discount' => $request->discount,
            'is_archive' => $request->is_archive,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'level created successfully',
            'data' => new LevelResource($level),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:levels,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Level ID'
            ], 404);
        }
        $query = Level::query();
        $query->with('user');
        $query->withCount('customers');
        $level = $query->find($id);


        return response()->json([
            "message" => "Level retrieved successfully",
            "data" => new LevelResource($level),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:levels,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Level ID'
            ], 404);
        }

        $level = Level::find($id);

        $level->update([
            'level' => $request->level,
            'discount' => $request->discount,
            'is_archive' => $request->is_archive
        ]);

        return response()->json([
            'message' => 'Level updated successfully',
            'data' => new LevelResource($level),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:levels,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Level ID'
            ], 404);
        }

        $level = Level::find($id);


        if ($level->is_archive) {
            $level->update([
                'is_archive' => null,
            ]);
        } else {
            $level->update([
                'is_archive' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Level archive successfully'
        ]);
    }
}

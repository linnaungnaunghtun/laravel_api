<?php
namespace App\Http\Controllers;

use App\Http\Resources\EcommerceUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EcommerceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // INITIALIZE BASE QUERY

        $query = User::query();

        // MUST Customer Role

        $query->where('role', 'customer');

        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // FILTER FUNCTIONALITY

        // $filterBy = $request->input('filter_by');
        // $filterVal = $request->input('filter_val');

        // if ($filterBy && $filterVal) {
        //     $query->where($filterBy, $filterVal);
        // }

        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'name'];
        $sortBy           = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection    = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $query->with('addresses', 'customer');

        // PAGINATION
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;
        // dd($query->toSql());
        $customers = $query->paginate($limit);

        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $customers->appends([
            'q'              => $searchTerm,
            'sort_by'        => $sortBy,
            'sort_direction' => $sortDirection,
            'limit'          => $limit,
        ]);

        // RETURN RESULTS

        return EcommerceUserResource::collection($customers);
    }

    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id',

        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid User ID',
            ], 404);
        }

        // $customer = User::with('addresses')
        //     ->where('id', $id)
        //     ->first();

        $customer = User::where("id",$id)->with("addresses")->first();

        return response()->json([
            "message" => "Customer user retrieved successfully",
            "data"    => new EcommerceUserResource($customer),
        ]);
    }
}

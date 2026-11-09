<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // INITIALIZE BASE QUERY

        $query = Customer::query();


        // SEARCH FUNCTIONALITY

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('age_range', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('city', 'like', '%' . $searchTerm . '%')
                    ->orWhere('township', 'like', '%' . $searchTerm . '%');
            });
        }


        // FILTER FUNCTIONALITY

        $filterBy = $request->input('filter_by');
        $filterVal = $request->input('filter_val');

        if ($filterBy && $filterVal) {
            $query->where($filterBy, $filterVal);
        }


        // SORT FUNCTIONALITY

        $validSortColumns = ['id', 'name', 'age', 'level_id'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';

        $query->orderBy($sortBy, $sortDirection);


        // LOAD RELATIONSHIPS

        $query->with('user');


        // PAGINATION

        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;

        $customers = $query->paginate($limit);


        // APPEND QUERY PARAMETERS TO PAGINATION LINKS

        $customers->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
            'filter_by' => $filterBy,
            'filter_val' => $filterVal,
        ]);


        // RETURN RESULTS
       

        return CustomerResource::collection($customers);
    }
    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "age" => $request->age,
            "age_range" => $request->age_range,
            "address" => $request->address,
            "gender" => $request->gender,
            "level_id" => $request->level_id,
            "city" => $request->city,
            "township" => $request->township,
            "remark" => $request->remark,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Customer created successfully',
            'data' => new CustomerResource($customer),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:customers,id',

        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Customer ID'
            ], 404);
        }

        $customer = Customer::find($id);

        return response()->json([
            "message" => "Customer retrieved successfully",
            "data" => new CustomerResource($customer)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Invalid Customer ID'
            ], 404);
        }

        // Update the model with the request data
        $customer->update($request->only([
            'name',
            "age",
            'age_range',
            'phone',
            'email',
            'address',
            "remark",
            "gender",
            "city",
            "township",
            "level_id"
        ]));

        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => new CustomerResource($customer),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:customers,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Customer ID'
            ], 404);
        }

        $customer = Customer::find($id);

        if ($customer->is_archive) {
            $customer->update([
                'is_archive' => null,
            ]);
            return response()->json([
                'message' => 'Customer restore successfully'
            ]);
        }

        $customer->update([
            'is_archive' => now(),
        ]);

        return response()->json([
            'message' => 'Customer archive successfully'
        ]);
    }

    public function excelImport(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid file format or size'
            ], 422);
        }


        $file = $request->file('file');
        $rows = Excel::toArray([], $file)[0];

        if (empty($rows)) {
            return response()->json([
                'message' => 'File is empty'
            ], 422);
        }

        $headers = array_shift($rows);
        $processedData = array_map(function ($row) use ($headers) {
            return array_combine($headers, $row);
        }, $rows);


        $newCustomers = [];

        foreach ($processedData as $data) {
            $newCustomer = (object) $data;
            if (!isset($newCustomer->name) || !isset($newCustomer->phone) || !isset($newCustomer->level_id)) {
                continue; // Skip if name or phone is not set
            }
            $newCustomers[] = [
                "name" => $newCustomer->name,
                "email" => $newCustomer->email,
                "address" => $newCustomer->address ?? null,
                "city" => $newCustomer->city ?? null,
                "township" => $newCustomer->township ?? null,
                "phone" => $newCustomer->phone,
                "gender" => $newCustomer->gender,
                "age" => $newCustomer->age,
                "remark" => $newCustomer->remark,
                "age_range" => $newCustomer->age_range,
                "level_id" => $newCustomer->level_id,
                "user_id" => Auth::id()
            ];
        }

        // Customer::insert($newCustomers);

        foreach ($newCustomers as $newCustomer) {
            Customer::updateOrCreate(
                ['phone' => $newCustomer['phone']],
                $newCustomer
            );
        }

        return response()->json([
            'message' => 'File imported successfully',
            'count' => count($processedData)
        ]);
    }

    public function excelExport()
    {
        return Excel::download(new CustomerExport, 'customers_' . now()->format('Y-m-d') . '.xlsx');
    }
}

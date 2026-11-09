<?php

namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreECommerceCustomer;
use App\Http\Resources\ECommerceCustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ECommerceCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return response()->json([
                'message' => 'Please Create Customer Profile',
            ], 404);
        }

        return response()->json([
            "message" => "Customer retrieved successfully",
            "data"    => new ECommerceCustomerResource($customer),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreECommerceCustomer $request)
    {

        $isExistedCustomer = Customer::whereLike('phone', "%" . $request->phone)->first();

        if ($isExistedCustomer) {
            $isExistedCustomer->update([
                'name'     => $request->name,
                'phone'    => $request->phone,
                'email'    => auth()->user()->email,
                'user_id'  => auth()->id(),
                'address' => $request->address_detail ?? null,
                'city' => $request->city ?? null,
                'township' => $request->township ?? null,
            ]);
            return response()->json([
                'message' => 'Customer created successfully',
                'data'    => new ECommerceCustomerResource($isExistedCustomer),
            ]);
        } else {
            $customer = Customer::create([
                'name'     => $request->name,
                'phone'    => $request->phone,
                'email'    => auth()->user()->email,
                'user_id'  => auth()->id(),
                'level_id' => 1,
                'address' => $request->address_detail ?? null,
                'city' => $request->city ?? null,
                'township' => $request->township ?? null,
            ]);
            return response()->json([
                'message' => 'Customer created successfully',
                'data'    => new ECommerceCustomerResource($customer),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show()
    // {

    //     $customer = Customer::where('user_id', Auth::id())->first();

    //     if (! $customer) {
    //         return response()->json([
    //             'message' => 'Unauthorized or Customer item not found',
    //         ], 403);
    //     }

    //     return response()->json([
    //         "message" => "Customer retrieved successfully",
    //         "data"    => new ECommerceCustomerResource($customer),
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find(Auth::id());

        if (! $customer) {
            return response()->json([
                'message' => 'Please Create Customer Profile',
            ], 404);
        }

        // Update the model with the request data
        $customer->update($request->only([
            'name',
            'phone',
            'email',
        ]));

        return response()->json([
            'message' => 'Customer updated successfully',
            'data'    => new ECommerceCustomerResource($customer),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}

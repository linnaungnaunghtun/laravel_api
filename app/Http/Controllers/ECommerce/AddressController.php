<?php

namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Http\Resources\AddressResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;





class AddressController extends Controller
{

    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->where("is_archive",null)->get();
        return AddressResource::collection($addresses);
    }


    public function store(StoreAddressRequest $request)
    {
        $address = Address::create([
            'address_detail' => $request->address_detail,
            'city' => $request->city,
            'township' => $request->township,
            'phone' => $request->phone,
            'note' => $request->note,
            'is_default' => $request->is_default ?? 1,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Address created successfully',
            'data' => new AddressResource($address)
        ]);
    }


    public function show($id)
    {

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:addresses,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Address ID'
            ], 404);
        }

        $address = Address::find($id);

        if ($address->user_id != Auth::id()) {
            return response()->json([
                'message' => 'Invalid Address ID'
            ], 404);
        }

        return response()->json([
            'message' => 'Address retrieved successfully',
            'data' => new AddressResource($address)
        ]);
    }



    public function update(UpdateAddressRequest $request, $id)
    {
        $address = Address::find($id);

        if (! $address) {
            return response()->json([
                'message' => 'Invalid Address ID',
            ], 404);
        }

        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $address->update($request->only([
            'address_detail',
            'city',
            'township',
            'phone',
            'note',
            'is_default',
        ]));

        return response()->json([
            'message' => 'Address updated successfully',
            'data'    => new AddressResource($address),
        ]);
    }


    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:addresses,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Address ID',
            ], 404);
        }

        $address = Address::find($id);


        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $address->update([
            "is_archive" => now()
        ]);

        return response()->json([
            'message' => 'Address deleted successfully',
        ]);
    }
}

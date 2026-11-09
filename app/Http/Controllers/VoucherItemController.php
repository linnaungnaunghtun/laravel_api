<?php

namespace App\Http\Controllers;

use App\Exports\VoucherItemsExport;
use App\Exports\VouchersExport;
use App\Models\VoucherItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VoucherItemResource;
use App\Http\Requests\StoreVoucherItemRequest;
use App\Http\Requests\UpdateVoucherItemRequest;
use App\Models\Voucher;
use Maatwebsite\Excel\Facades\Excel;

class VoucherItemController extends Controller
{

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($request->export_type === "vouchers") {
            $query = Voucher::query();
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $query->with('user', 'customer');
            $orderItems = $query->get();
            return Excel::download(new VouchersExport($orderItems), 'vouchers_export.xlsx');
        }

        $query = VoucherItem::query();
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        $query->with('user');
        $orderItems = $query->get();


        return Excel::download(new VoucherItemsExport($orderItems), 'voucher_items_export.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        $validSortColumns = ['id', 'voucher_id', 'product_id', 'barcode', 'price', 'quantity', 'discount_percent', 'discount_cash', 'cost'];
        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int)$limit : 5;
        $query = VoucherItem::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('barcode', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('price', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('quantity', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('discount_percent', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('discount_cash', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('cost', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user', 'voucher', 'product');

        // return $query->tosql();

        $voucher_items = $query->paginate($limit);

        $voucher_items->appends([
            'q' => $searchTerm,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        return VoucherItemResource::collection($voucher_items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherItemRequest $request)
    {

        $voucher_item = VoucherItem::create([
            'voucher_id' => $request->voucher_id,
            'product_id' => $request->product_id,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'discount_percent' => $request->discount_percent,
            'discount_cash' => $request->discount_cash,
            'cost' => $request->cost,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Voucher Item created successfully',
            'data' => new VoucherItemResource($voucher_item),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:voucher_items,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Voucher Item ID'
            ], 404);
        }

        $voucher_item = VoucherItem::find($id);

        return response()->json([
            "message" => "Voucher Item retrieved successfully",
            "data" => new VoucherItemResource($voucher_item),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherItemRequest $request, $id)
    {

        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:voucher_items,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Voucher Item ID'
            ], 404);
        }

        $voucher_item = VoucherItem::find($id);

        $voucher_item->update([
            'voucher_id' => $request->voucher_id,
            'product_id' => $request->product_id,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'discount_percent' => $request->discount_percent,
            'discount_cash' => $request->discount_cash,
            'cost' => $request->cost,
        ]);

        return response()->json([
            'message' => 'Voucher Item updated successfully',
            'data' => new VoucherItemResource($voucher_item),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:voucher_items,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Voucher Item ID'
            ], 404);
        }

        $voucher_item = VoucherItem::find($id);
        $voucher_item->delete();

        return response()->json([
            "message" => "Voucher Item deleted successfully",
        ]);
    }
}

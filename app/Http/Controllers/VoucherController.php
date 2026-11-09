<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Voucher;
use App\Models\VoucherItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm       = $request->input('q');
        $validSortColumns = ['id', 'net_total', 'voucher_date'];
        $sortBy           = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection    = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $limit            = $request->input('limit', 5);
        $limit            = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : 5;
        $query            = Voucher::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('voucher_no', 'like', '%' . $searchTerm . '%');
                // ->orWhere('type', 'like',  '%' . $searchTerm . '%')
                // ->orWhere('payment_method', 'like',  '%' . $searchTerm . '%')
                // ->orWhere('discount_percent', 'like',  '%' . $searchTerm . '%')
                // ->orWhere('discount_cash', 'like',  '%' . $searchTerm . '%')
                // ->orWhere('tax', 'like',  '%' . $searchTerm . '%')
                // ->orWhere('total', 'like',  '%' . $searchTerm . '%')
                // ->orWhere('total_charges', 'like',  '%' . $searchTerm . '%');
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $query->with('user', 'customer');

        // return $query->tosql();

        $voucher = $query->paginate($limit);

        $voucher->appends([
            'q'              => $searchTerm,
            'sort_by'        => $sortBy,
            'sort_direction' => $sortDirection,
            'limit'          => $limit,
        ]);

        return VoucherResource::collection($voucher);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        try {
            DB::beginTransaction();

            // create voucher

            $voucher = Voucher::create([
                "cash_discount"           => $request->cash_discount ?? 0,
                "customer_id"             => $request->customer_id,
                "discount_percent_amount" => $request->discount_percent_amount,
                "discount_percentage"     => $request->discount_percentage,
                "net_total"               => $request->net_total,
                "payment_method"          => $request->payment_method,
                "sale_type"               => $request->sale_type,
                "tax"                     => $request->tax,
                "tax_amount"              => $request->tax_amount,
                "total"                   => $request->total,
                "voucher_date"            => $request->voucher_date,
                "voucher_no"              => $request->voucher_no,
                "user_id"                 => auth()->id(),
                "created_at"              => now(),
                "updated_at"              => now(),
            ]);

            // create voucher item

            $items = [];

            foreach ($request->items as $item) {

                $item    = (object) $item;
                $product = (object) $item->product;
                $size    = (object) $item->size;

                $items[] = [
                    "voucher_id"     => $voucher->id,
                    "product_id"     => $item->product_id,
                    "product_name"   => $product->product_name,
                    "product_code"   => $product->product_code,
                    "barcode"        => $item->barcode,
                    "size_name"      => $size->size,
                    "size_id"        => $item->size_id,
                    "original_price" => $product->original_price,
                    "display_price"  => $product->display_price,
                    "discount"       => $product->discount,
                    "sale_price"     => $product->sale_price,
                    "profit"         => $product->sale_price - $product->original_price,
                    "user_id"        => auth()->id(),
                    "voucher_id_code" => $voucher->voucher_no,
                    "customer_name" => $voucher->customer->name ?? '',
                    "customer_phone" => $voucher->customer->phone ?? '',
                    "customer_id" => $voucher->customer_id,
                    "sale_type" => $voucher->sale_type,
                    "brand_name" => $product->brand->brand_name ?? '',
                    "brand_id" => $product->brand_id ?? '',
                    "category_name" => $product->category->category_name ?? '',
                    "category_id" => $product->category_id ?? '',
                    "fit_name" => $product->fit->name ?? '',
                    "fit_id" => $product->fit_id ?? '',
                    "created_at"     => now(),
                    "updated_at"     => now(),
                ];
            }

            VoucherItem::insert($items);

            $voucher->net_profit = array_reduce($items, function ($carry, $item) {
                $item = (object) $item;
                return $carry + $item->profit;
            }, 0) - ($voucher->discount_percent_amount + $voucher->cash_discount + $voucher->tax_amount);

            $voucher->save();

            // remove stocks from stock
            Stock::whereIn("barcode", collect($request->items)->pluck('barcode'))->get()
                ->each
                ->delete();;

            // update stocks_count form product
            // $productIds = collect($request->items)->pluck('product_id');
            // $products   = Product::whereIn('id', $productIds)->withCount(['stocks as sc'])->get();
            // foreach ($products as $product) {
            //     $product->update(['stocks_count' => $product->sc]);
            // }

            DB::commit();

            return response()->json([
                'message' => 'Voucher created successfully',
                'data'    => new VoucherResource($voucher),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:vouchers,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Voucher ID',
            ], 404);
        }

        $voucher = Voucher::find($id);

        return response()->json([
            "message" => "Voucher retrieved successfully",
            "data"    => new VoucherResource($voucher),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, $id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:vouchers,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Voucher ID',
            ], 404);
        }

        $voucher = Voucher::find($id);

        $voucher->update([
            'customer_id'      => $request->customer_id,
            'type'             => $request->type,
            'payment_method'   => $request->payment_method,
            'discount_percent' => $request->discount_percent,
            'discount_cash'    => $request->discount_cash,
            'tax'              => $request->tax,
            'total'            => $request->total,
            'total_charges'    => $request->total_charges,
        ]);

        return response()->json([
            'message' => 'Voucher updated successfully',
            'data'    => new VoucherResource($voucher),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:vouchers,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Voucher ID',
            ], 404);
        }

        $voucher = Voucher::find($id);
        $voucher->delete();

        return response()->json([
            "message" => "Voucher deleted successfully",
        ]);
    }
}

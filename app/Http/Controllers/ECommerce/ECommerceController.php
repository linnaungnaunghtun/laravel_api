<?php

namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Resources\ECommerceCouponResource;
use App\Http\Resources\ECommerceProductDetailResource;
use App\Http\Resources\ECommerceProductResource;
use App\Http\Resources\ECommerceReviewResource;
use App\Http\Resources\ECommerceSearchSuggestionResource;
use App\Http\Resources\ECommerceStockCheckResource;
use App\Http\Resources\StockResource;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Fit;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Review;
use App\Models\ShopCategory;
use App\Models\Size;
use App\Models\Slider;
use App\Models\Stock;
use Illuminate\Http\Request;

class ECommerceController extends Controller
{
    public function index()
    {
        $response = [
            "message"      => "Welcome from Boss Nation POS API",
            "developed_by" => "MMS IT",
            "website"      => "https://mms-it.com",
            "contact"      => "+66825869290",
        ];
        return response()->json($response);
    }

    public function review(Request $request)
    {
        $reviews = Review::where('product_id', $request->product_id)->with('user')->get();
        return ECommerceReviewResource::collection($reviews);
    }

    public function slide()
    {
        $slides = Slider::all();
        return response()->json($slides);
    }

    public function banner()
    {
        $banners = Banner::all();
        return response()->json($banners);
    }

    public function brand()
    {

        $brands = Brand::where('is_archive', null)->get();
        return response()->json($brands);
    }

    public function productType()
    {
        $productTypes = ProductType::where('is_archive', null)->get();
        return response()->json($productTypes);
    }

    public function productCategory()
    {
        $productCategories = Category::where('is_archive', null)->get();
        return response()->json($productCategories);
    }

    public function productFitting()
    {
        $fittings = Fit::where('is_archive', null)->get();
        return response()->json($fittings);
    }

    public function productSize()
    {
        $sizes = Size::where('is_archive', null)->get();
        return response()->json($sizes);
    }

    public function shopCategory()
    {
        $shopCategories = ShopCategory::latest("id")->limit(4)->get();
        return response()->json($shopCategories);
    }

    public function latest()
    {
        $query = Product::query();
        $query->where('is_archive', null);
        $query->where("is_ecommerce", 1);
        $query->where("stocks_count", ">", 0);
        $query->latest("id");
        $query->limit(4);
        $query->with(["brand", "productImage"]);
        $products = $query->get();
        return response()->json(ECommerceProductResource::collection($products));
    }

    public function shop(Request $request)
    {

        // INITIALIZE BASE QUERY
        $query = Product::query();

        // SEARCH FUNCTIONALITY
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('product_code', 'like', '%' . $searchTerm . '%');
            });
        }

        // MUST FILTER
        $query->where("is_ecommerce", 1);
        $query->where("stocks_count", ">", 0);
        $query->where('is_archive', null);


        // FILTER PRICE FUNCTIONALITY
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        if ($minPrice && $maxPrice) {
            $query->whereBetween('sale_price', [$minPrice, $maxPrice]);
        }

        // FILTER discount
        $discount = $request->input('discount');
        if ($discount) {
            $query->where('discount', '>=', $request->discount);
        }


        // FILTER GENDER FUNCTIONALITY
        $gender = $request->input('gender');
        if ($gender && in_array($gender, config("base.product_genders"))) {
            if ($request->gender === "men") {
                $query->where(function ($q) {
                    $q->where("gender", "men")
                        ->orWhere("gender", "unisex");
                });
            } else if ($request->gender === "women") {
                $query->where(function ($q) {
                    $q->where("gender", "women")
                        ->orWhere("gender", "unisex");
                });
            } else if ($request->gender === "unisex") {
                $query->where("gender", "unisex");
            }
        }

        // FILTER FUNCTIONALITY
        $validFilterColumns = ['product_type_id', 'category_id', 'brand_id', 'fit_id', "stocks_count", "discount", "size_name"];
        $filters            = $request->input('filters', []);
        if (! empty($filters)) {
            foreach ($filters as $column => $value) {
                if (! empty($column) && in_array($column, $validFilterColumns) && ! empty($value)) {
                    if ($column === "size_name") {
                        $query->whereLike("available_size", "%.$value.%");
                    } else {
                        $query->where($column, $value);
                    }
                }
            }
        }

        // SORT FUNCTIONALITY
        $validSortColumns = ['id', 'sale_price', 'discount', "stocks_count", "product_name"];
        $sortBy           = in_array($request->input('sort_by'), $validSortColumns, true) ? $request->input('sort_by') : 'id';
        $sortDirection    = in_array($request->input('sort_direction'), ['asc', 'desc'], true) ? $request->input('sort_direction') : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        // LOAD RELATIONSHIPS AND COUNTS
        $query->with(["brand", "productImage"]);

        // PAGINATION
        $defaultPaginationLimit = 20;
        $limit                  = $request->input('limit', $defaultPaginationLimit);
        $limit                  = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : $defaultPaginationLimit;
        $products               = $query->paginate($limit);

        // APPEND QUERY PARAMETERS TO PAGINATION LINKS
        $products->appends([
            'q'              => $searchTerm,
            'sort_by'        => $sortBy,
            'sort_direction' => $sortDirection,
            'limit'          => $limit,
            'gender'         => $gender,
            'min_price'      => $minPrice,
            'max_price'      => $maxPrice,
            'filters'        => $filters,
        ]);

        // RETURN RESULTS
        return ECommerceProductResource::collection($products);
    }

    public function searchSuggestion(Request $request)
    {
        $query = Product::query();

        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('product_code', 'like', '%' . $searchTerm . '%');
            });
        }

        // MUST FILTER
        $query->where("is_ecommerce", 1);
        $query->where("stocks_count", ">", 0);
        $query->where('is_archive', null);


        // LOAD RELATIONSHIPS AND COUNTS
        $query->with('productImage');

        // PAGINATION
        $defaultPaginationLimit = 5;
        $limit                  = $request->input('limit', $defaultPaginationLimit);
        $limit                  = is_numeric($limit) && $limit > 0 && $limit <= 100 ? (int) $limit : $defaultPaginationLimit;
        $products               = $query->paginate($limit);

        // APPEND QUERY PARAMETERS TO PAGINATION LINKS
        $products->appends([
            'q' => $searchTerm,
            'limit' => $limit,
        ]);

        return ECommerceSearchSuggestionResource::collection($products);
    }

    public function productDetail($slug)
    {
        $product = Product::where("slug", $slug)->where('is_ecommerce', 1)->where('is_archive', null)->first();
        if (! $product) {
            return response()->json(["message" => "Product not found"], 404);
        }
        return new ECommerceProductDetailResource($product);
    }


    public function stockCheck(Request $request)
    {
        $stocks = Stock::where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)->get();

        $orderItems = OrderItem::where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)->where("sold", 0)->get();

        // return ["stocks" => $stocks, "order_items" => $orderItems];
        return ["stocks" => $stocks->count(), "order_items" => $orderItems->count()];

        if (count($stocks) == 0) {
            return response()->json(["message" => "Product not found"], 404);
        }
        return response()->json(ECommerceStockCheckResource::collection($stocks));
    }


    public function couponCheck(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('is_archive', null)
            ->where("expire_date", ">=", now())
            ->first();

        if (! $coupon) {
            return response()->json(["message" => "Invalid Coupon Code"], 404);
        }

        return response()->json(new ECommerceCouponResource($coupon));
    }
}

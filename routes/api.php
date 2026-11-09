<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EcommerceUserController;
use App\Http\Controllers\ECommerce\AddressController;
use App\Http\Controllers\ECommerce\AuthController as ECommerceAuthController;
use App\Http\Controllers\ECommerce\CartController;
use App\Http\Controllers\ECommerce\ECommerceController;
use App\Http\Controllers\ECommerce\ECommerceOrderCancelController;
use App\Http\Controllers\ECommerce\ECommerceOrderController;
use App\Http\Controllers\ECommerce\ProfileController as ECommerceProfileController;
use App\Http\Controllers\ECommerce\ReviewController;
use App\Http\Controllers\ECommerce\WishlistController;
use App\Http\Controllers\FitController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\OrderController as PosOrderController;
use App\Http\Controllers\OrderItemController as PosOrderItemController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewManageController;
use App\Http\Controllers\ShopCategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ECommerce\ECommerceCustomerController;



Route::prefix("pos")->group(function () {
    Route::get("/", function () {
        $response = [
            "message"      => "Welcome from Boss Nation POS API",
            "developed_by" => "MMS IT par",
            "website"      => "https://mms-it.com",
            "contact"      => "+66825869290",
        ];
        return response()->json($response);
    });
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(ProfileController::class)->prefix("user-profile")->group(function () {
            Route::post('/logout', 'logout');
            Route::get('/profile', 'profile');
            Route::post('/change-password', 'changePassword');
            Route::post('/change-name', 'changeName');
            Route::post('/change-profile-image', 'changeProfileImage');
        });
        Route::apiResource('gallery', GalleryController::class)->except('update');
        Route::apiResource('brand', BrandController::class);
        Route::apiResource('size', SizeController::class);
        Route::apiResource('product-type', ProductTypeController::class);
        Route::apiResource('fitting', FitController::class);
        Route::apiResource('product-category', CategoryController::class);
        Route::apiResource('slider', SliderController::class);
        Route::apiResource('banner', BannerController::class);
        Route::apiResource('coupon', CouponController::class);
        Route::apiResource("customer", CustomerController::class);
        Route::post("customer-excel-import", [CustomerController::class, 'excelImport']);
        Route::get("customer-excel-export", [CustomerController::class, 'excelExport']);
        Route::apiResource('level', LevelController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('vouchers', VoucherController::class);
        Route::apiResource('voucher-items', VoucherItemController::class);
        Route::post('voucher-items-export', [VoucherItemController::class, 'export']);
        Route::apiResource('products-image', ProductImageController::class);
        Route::apiResource('shop-category', ShopCategoryController::class);
        Route::apiResource('review', ReviewManageController::class);
        Route::get('review-count', [ReviewManageController::class, 'reviewCount']);
        Route::patch('review/{id}/update-is-publish', [ReviewManageController::class, 'updateIsPublish']);
        Route::apiResource('stock', StockController::class);
        Route::get("/stock-check", [StockController::class, 'stockCheck']);
        Route::get("stock/stock-with-barcode/{barcode}", [StockController::class, "showWithBarcode"]);
        Route::apiResource('e-commerce-users', EcommerceUserController::class);
        Route::apiResource('orders', PosOrderController::class);
        Route::post("orders-confirm", [PosOrderController::class, 'orderConfirm']);
        Route::post("orders-deliver", [PosOrderController::class, "orderDeliver"]);
        Route::post("orders-complete", [PosOrderController::class, "orderComplete"]);
        Route::post("orders-cancel", [PosOrderController::class, "orderCancel"]);
        Route::get("orders-count", [PosOrderController::class, "orderCount"]);
        Route::apiResource('order-items', PosOrderItemController::class);
        Route::post('order-status', [OrderStatusController::class, 'orderStatus']);
    });
});

Route::prefix("e-commerce")->group(function () {

    Route::controller(ECommerceController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/slide', 'slide');
        Route::get('/brand', 'brand');
        Route::get('/banner', 'banner');
        Route::get('/product-type', 'productType');
        Route::get('/product-fitting', 'productFitting');
        Route::get('/product-size', 'productSize');
        Route::get('/product-category', 'productCategory');
        Route::get('/latest', 'latest');
        Route::get('/shop', 'shop');
        Route::get('/shop/{slug}', 'productDetail');
        Route::get('/search-suggestion', 'searchSuggestion');
        Route::get('/shop-category', 'shopCategory');
        Route::get('/product-review', 'review');
        Route::get('/stock-check', 'stockCheck');
        Route::get('/coupon-check', 'couponCheck');
    });

    Route::controller(ECommerceAuthController::class)->group(function () {
        Route::post('/login', 'login');
    });

    Route::middleware('auth:sanctum')->prefix('dashboard')->group(function () {
        Route::controller(ECommerceProfileController::class)->prefix("user-profile")->group(function () {
            Route::post('/logout', 'logout');
            Route::get('/profile', 'profile');
            Route::post('/change-name', 'changeName');
            Route::post('/change-profile-image', 'changeProfileImage');
        });
        Route::apiResource('wishlist', WishlistController::class);
        Route::apiResource('cart', CartController::class);
        Route::apiResource('address', AddressController::class);
        Route::apiResource('user-review', ReviewController::class);
        Route::apiResource('e-commerce-customer', ECommerceCustomerController::class)->except(["show", "destroy"]);
        Route::apiResource('order', ECommerceOrderController::class);

        Route::post('order-cancel', [ECommerceOrderController::class, 'orderCancel']);
    });
});

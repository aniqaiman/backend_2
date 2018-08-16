<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('reset-password', 'ResetPasswordController@getResetToken');
Route::get('auth/user', 'Api\ApiController@getAuthUser');
Route::get('auth/verify/{token}', 'Api\ApiController@verifyUserEmail');

Route::post('auth/login', 'Api\ApiController@login');
Route::post('auth/verifyrecaptcha', 'Api\ApiController@verifyReCAPTCHA');

Route::post('users/sellers', 'Api\SellerController@store');
Route::put('users/sellers', 'Api\SellerController@update');
Route::post('users/buyers', 'Api\BuyerController@store');
Route::put('users/buyers', 'Api\BuyerController@update');

// ------------------------------------------- Feedback ---------------------------------------------------- //

Route::get('{type}/feedbacks', 'Api\FeedbackController@getFeedbacks');
Route::get('{type}/feedbacks/unread', 'Api\FeedbackController@getUnreadFeedbacks');
Route::get('{type}/feedbacks/{id}', 'Api\FeedbackController@getSingleFeedback');
Route::put('{type}/feedbacks/read/{id}', 'Api\FeedbackController@setReadFeedback');
Route::put('{type}/feedbacks/response/{id}', 'Api\FeedbackController@updateResponseFeedback');

Route::get('products', 'Api\ProductController@getProducts');
Route::get('products/minimal', 'Api\ProductController@getMinimalProducts');
Route::get('products/latest', 'Api\ProductController@getNewProducts');
Route::get('products/lastpurchase', 'Api\ProductController@getLastPurchaseProducts');
Route::get('products/popular', 'Api\ProductController@getBestSellingProducts');
Route::get('products/{product_id}', 'Api\ProductController@getProductbyId');
Route::get('products/{product_id}/price', 'Api\PriceController@getProductPriceLatest');
Route::get('products/{product_id}/price/difference', 'Api\PriceController@getProductPriceDifference');
Route::get('fruits', 'Api\ProductController@getFruits');
Route::get('fruits/goto', 'Api\ProductController@getFruitsByPage');
Route::get('fruits/minimal', 'Api\ProductController@getMinimalFruits');
Route::get('fruits/minimal/goto', 'Api\ProductController@getMinimalFruitsByPage');
Route::get('vegetables', 'Api\ProductController@getVegetables');
Route::get('vegetables/goto', 'Api\ProductController@getVegetablesByPage');
Route::get('vegetables/minimal', 'Api\ProductController@getMinimalVegetables');
Route::get('vegetables/minimal/goto', 'Api\ProductController@getMinimalVegetablesByPage');
Route::get('prices', 'Api\ProductController@getPrices');
Route::get('buyers', 'Api\BuyerController@getBuyers');
Route::get('sellers', 'Api\SellerController@getSellers');
Route::get('buyer/{user_id}', 'Api\BuyerController@getBuyer');
Route::get('seller/{user_id}', 'Api\SellerController@getSeller');

// ------------------------------------------- Order ---------------------------------------------------- //

Route::get('orders', 'Api\OrderController@getOrders');
Route::get('orders/rejects', 'Api\OrderController@getOrderRejects');
Route::get('orders/{order_id}', 'Api\OrderController@getOrderDetails');

// ------------------------------------------- Stock ---------------------------------------------------- //

Route::get('stocks', 'Api\StockController@getStocks');
Route::get('stocks/{stock_id}', 'Api\StockController@getStockDetails');

Route::post('stocks', 'Api\StockController@postStocks');

// ------------------------------------------- Cart ---------------------------------------------------- //

Route::get('carts', 'Api\CartController@getCartItems');
Route::get('carts/products/{product_id}', 'Api\CartController@getCartItem');
Route::get('carts/totalitems', 'Api\CartController@getTotalItems');
Route::get('carts/totalprice', 'Api\CartController@getTotalPrice');

Route::post('carts', 'Api\CartController@postCartItem');
Route::post('carts/confirm', 'Api\CartController@postConfirm');

Route::delete('carts/{product_id}', 'Api\CartController@deleteCartItem');

// ------------------------------------------- Supply ---------------------------------------------------- //

Route::get('supplies', 'Api\SupplyController@getSupplies');
Route::post('supplies', 'Api\SupplyController@postSupplies');

Route::get('playground', 'Api\ApiController@playground');

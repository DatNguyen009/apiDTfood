<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\customers;

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


//api user
Route::resource('/v1/customers', 'App\Http\Controllers\PostController');
Route::post('/v1/login', 'App\Http\Controllers\LoginController@login');
Route::post('/v1/register', 'App\Http\Controllers\LoginController@PostRegister');
Route::post('/v1/forgetpass', 'App\Http\Controllers\LoginController@ForgetPass');


//api product
Route::resource('/v1/products', 'App\Http\Controllers\ProductController');
Route::apiResource('/v1/productspaginate', 'App\Http\Controllers\ProductPaginationController');
Route::apiResource('/v1/productDetail', 'App\Http\Controllers\ProductDetailController')->only(['show']);
Route::get('/v1/relatedFood/', 'App\Http\Controllers\RelatedFoodController@relatedFood');
Route::get('/v1/trendingFood', 'App\Http\Controllers\RelatedFoodController@trendingFood');

//api order and cart
Route::apiResource('/v1/customerOrder', 'App\Http\Controllers\CustomerOrderController');
Route::apiResource('/v1/multiOrder', 'App\Http\Controllers\MultiOrder');
Route::apiResource('/v1/cart', 'App\Http\Controllers\CartController');


//api admin
Route::apiResource('/v1/materials', 'App\Http\Controllers\MaterialsController');
Route::apiResource('/v1/NKNVL', 'App\Http\Controllers\NKNVLController');
Route::apiResource('/v1/kitchen', 'App\Http\Controllers\KitchenController');
Route::apiResource('/v1/ncc', 'App\Http\Controllers\NccController');
Route::apiResource('/v1/setPriceNcc', 'App\Http\Controllers\SetPriceNccController');
Route::apiResource('/v1/softDeleted', 'App\Http\Controllers\SoftDeletedController');
Route::apiResource('/v1/admin', 'App\Http\Controllers\AdminLoginController');
Route::apiResource('/v1/adminLogin', 'App\Http\Controllers\LoginController@loginAdmin');
Route::apiResource('/v1/uploadFood', 'App\Http\Controllers\UploadFoodController');
Route::post('/v1/postCategory', 'App\Http\Controllers\CategoryController@postCategory');
Route::get('/v1/getCategory/{id}', 'App\Http\Controllers\CategoryController@show');
Route::post('/v1/postImage', 'App\Http\Controllers\PostImageController@postImage');
Route::post('/v1/postMaterial', 'App\Http\Controllers\PostMaterialController@test');
Route::get('/v1/slugFoods', 'App\Http\Controllers\GetSlug@slugFood');
Route::get('/v1/slugMaterials', 'App\Http\Controllers\GetSlug@slugMaterials');
Route::get('/v1/getSlug/{id}', 'App\Http\Controllers\GetSlug@getSlug');
Route::get('/v1/slugCategory', 'App\Http\Controllers\GetSlug@slugCategory');
Route::get('/v1/getMaterialfollowSlug/{id}', 'App\Http\Controllers\GetSlug@getMaterialfollowSlug');
Route::get('/v1/historyPriceTimeSub/{id}', 'App\Http\Controllers\HistoryPrice@historyPriceSub');
Route::get('/v1/statistical/{id}', 'App\Http\Controllers\statisticalController@statistical');
Route::get('/v1/statisticalCost/{id}', 'App\Http\Controllers\statisticalController@statisticalCost');
Route::apiResource('/v1/orderManagement', 'App\Http\Controllers\OrderManagementController');
Route::get('/v1/dataOrder/{id}', 'App\Http\Controllers\DataChart@DataChartOrder');
Route::get('/v1/OrderDetail/{id}', 'App\Http\Controllers\DataChart@OrderDetail');
Route::apiResource('/v1/supplierPrice', 'App\Http\Controllers\supplierpriceController');
Route::apiResource('/v1/Managercustomers', 'App\Http\Controllers\UserManagementControllerr');



Route::apiResource('/v1/reviews', 'App\Http\Controllers\ReviewsController');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

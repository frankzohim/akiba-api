<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\CreateUserController;
use App\Http\Controllers\Api\User\CurrentUserController;
use App\Http\Controllers\Api\User\LogoutController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




 
Route::post('/user', [CreateUserController::class, 'createUser']);
Route::post('/login',[LoginController::class,'login']);



//Display images
Route::get('/categoryImage/{id}/{path}',[ProductCategoryController::class,'categoryImage']);
Route::get('/productImage/{id}/{path}',[ProductController::class,'productImage']);

//Listing on guest 

Route::get('/categoriesList', [ProductCategoryController::class, 'list']);
Route::get('/productsList', [ProductController::class, 'index']);

//Retrieving a product
Route::get('/getProduct/{product}', [ProductController::class, 'show']);
// Route::apiResource('/categories', ProductCategoryController::class);

// endpoint simple user

Route::middleware('auth:api')->prefix('v1')->group(function(){

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/currentUser',[CurrentUserController::class,'currentUser']);
    Route::post('/logout',[LogoutController::class,'logout']);

    //Brand resource
    Route::apiResource('/brands', BrandController::class);
    Route::post('/brand/image', [BrandController::class, 'uploadLogo']);

    //Category resource
    Route::apiResource('/categories', ProductCategoryController::class);
    Route::post('/category/image', [ProductCategoryController::class, 'uploadLogo']);

    //Store resource
    Route::apiResource('/stores', StoreController::class);
    Route::get('/stores/vendor/{userId}', [StoreController::class, 'vendorStores']);
    Route::post('/store/image', [StoreController::class, 'uploadImages']);
    
    //Product resource
    Route::apiResource('/products', ProductController::class);
    Route::post('/product/image', [ProductController::class, 'uploadImages']);
    Route::get('/products/store/{storeId}', [ProductController::class, 'productStore']);

 
});





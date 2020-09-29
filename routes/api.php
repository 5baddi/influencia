<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth:sanctum'], function(){
    // Get User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout action
    Route::post('/logout', 'AuthenticationController@logout');
});

// API V1 routes
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], function(){
    // Brands
    Route::get('/brands', 'BrandController@index');
    Route::post('/brands', 'BrandController@create');
    Route::put('/brands/{brand}', 'BrandController@update');
    Route::delete('/brands/{brand}', 'BrandController@destroy');
    // Route::get('/brand/{brand}/trackers', 'TrackerController@fetchByBrand');
});

// Route::middleware('auth:sanctum')->post('/register', 'UserController@register');

// Route::middleware('auth:sanctum')->get('/brands', 'BrandController@index');
// Route::middleware('auth:sanctum')->post('/brands', 'BrandController@create');
// Route::middleware('auth:sanctum')->put('/brand/{brand}', 'BrandController@update');
// Route::middleware('auth:sanctum')->get('/brand/{brand}/trackers', 'TrackerController@fetchByBrand');

// Route::middleware('auth:sanctum')->get('/users', 'UserController@index');
// Route::middleware('auth:sanctum')->post('/search', 'SearchController@search');
// Route::middleware('auth:sanctum')->post('/campaigns', 'CampaignController@create');
// Route::middleware('auth:sanctum')->get('/campaigns/{brand}', 'CampaignController@index');
// Route::middleware('auth:sanctum')->post('/trackers', 'TrackerController@create');
// Route::middleware('auth:sanctum')->post('/trackers/story', 'TrackerController@createStory');

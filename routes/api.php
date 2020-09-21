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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', 'AuthenticationController@logout');
Route::middleware('auth:sanctum')->post('/register', 'UserController@register');
Route::middleware('auth:sanctum')->post('/brands', 'BrandController@store');
Route::middleware('auth:sanctum')->get('/brands', 'BrandController@index');
Route::middleware('auth:sanctum')->get('/users', 'UserController@index');
Route::middleware('auth:sanctum')->post('/search', 'SearchController@search');
Route::middleware('auth:sanctum')->post('/campaigns', 'CampaignController@store');
Route::middleware('auth:sanctum')->get('/campaigns/{brand}', 'CampaignController@index');
Route::middleware('auth:sanctum')->get('/trackers/{campaign}', 'TrackerController@index');
Route::middleware('auth:sanctum')->post('/trackers/{campaign}', 'TrackerController@create');

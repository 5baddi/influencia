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


// Logout action
Route::post('/logout', 'AuthenticationController@logout');

Route::group(['middleware' => 'auth:sanctum'], function(){
    // Get User
    Route::get('/user', function (Request $request) {
        return response()->success("User fetched successfully.", $request->user());
    });

    // User permissions
    Route::get('/abilities', 'OAuthController@abilities');
});

// API V1 routes
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], function(){
    // Brands
    Route::get('/brands', 'BrandController@index');
    Route::post('/brands', 'BrandController@create');
    Route::get('/brands/{brand}', 'BrandController@show');
    Route::post('/brands/{brand}', 'BrandController@update');
    Route::delete('/brands/{brand}', 'BrandController@delete');
    Route::get('/brands/{brand}/trackers', 'TrackerController@fetchByBrand');

    // Campaigns
    Route::get('/campaigns/{brand}', 'CampaignController@byBrand');
    Route::get('/campaigns/{campaign}/analytics', 'CampaignController@analytics');
    Route::post('/campaigns', 'CampaignController@create');
    Route::delete('/campaigns/{campaign}', 'CampaignController@delete');

    // Trackers
    Route::post('/trackers', 'TrackerController@create');
    Route::post('/trackers/story', 'TrackerController@createStory');
    Route::get('/trackers/{tracker}/status', 'TrackerController@changeStatus');
    Route::delete('/trackers/{tracker}', 'TrackerController@delete');

    // Users
    Route::get('/users', 'UserController@index');
    Route::get('/users/{user}', 'UserController@show');
    Route::get('/users/active-brand/{brand}', 'UserController@changeActiveBrand');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{user}', 'UserController@update');
    Route::put('/users/{user}/reset', 'UserController@resetPassword');
    Route::delete('/users/{user}', 'UserController@delete');
    Route::get('/users/{user}/status', 'UserController@ban');

    // Roles & permissions
    Route::get('/roles', 'OAuthController@roles');
    Route::post('/roles', 'OAuthController@storeRole');
    Route::post('/permissions', 'OAuthController@storePermission');

    // Influencers
    Route::get('/influencers', 'InfluencerController@index');
    Route::get('/influencers/{influencer}', 'InfluencerController@show');

    // Export
    Route::get('/export/excel/{brand}/trackers', 'ExcelExportController@trackers');

    // Data && statistics
    Route::get('/dashboard', 'DataController@dashboardStatistics');
});

// Streamed data
Route::group(['prefix' => 'v1/stream'], function(){
    // Trackers
    Route::get('/{brand}/trackers', 'StreamController@trackers');
});

// Scraper
Route::group(['prefix' => '/v1/scraper/insta/'], function(){
    Route::get('/{username}', 'ScraperController@instagramByUsername');
    Route::get('/{id}', 'ScraperController@instagramById')->where('id', '[0-9]+');
    Route::get('/{influencer}/medias', 'ScraperController@instagramMedias');
});

// Route::middleware('auth:sanctum')->post('/register', 'UserController@register');

// Route::middleware('auth:sanctum')->get('/brands', 'BrandController@index');
// Route::middleware('auth:sanctum')->post('/brands', 'BrandController@create');
// Route::middleware('auth:sanctum')->put('/brand/{brand}', 'BrandController@update');
// Route::middleware('auth:sanctum')->get('/brand/{brand}/trackers', 'TrackerController@fetchByBrand');

// Route::middleware('auth:sanctum')->get('/users', 'UserController@index');
Route::middleware('auth:sanctum')->post('/search', 'SearchController@search');
// Route::middleware('auth:sanctum')->post('/campaigns', 'CampaignController@create');
// Route::middleware('auth:sanctum')->get('/campaigns/{brand}', 'CampaignController@index');
// Route::middleware('auth:sanctum')->post('/trackers', 'TrackerController@create');
// Route::middleware('auth:sanctum')->post('/trackers/story', 'TrackerController@createStory');

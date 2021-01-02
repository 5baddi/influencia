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

// API Status
Route::get('/status', function(){
    return response()->success("Welcome to " . env('APP_NAME') . " API");
});

// V2 Routes
Route::group(['prefix' => 'v2'], function(){
    // OAuth routes
    Route::group(['prefix' => 'oauth'], function(){
        // sign in
        Route::post('/signin', 'OAuthController@signIn');

        // sign out
        Route::post('/signout', 'OAuthController@signOut');
    });
});

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

    // Campaigns
    Route::get('/{brand}/campaigns/', 'CampaignController@byBrand');
    Route::get('/{brand}/campaigns/search/{query}', 'CampaignController@search');
    Route::get('/{brand}/campaigns/statistics', 'CampaignController@statistics');
    Route::get('/campaigns/{campaign}/analytics', 'CampaignController@analytics');
    Route::post('/campaigns', 'CampaignController@create');
    Route::put('/campaigns/{campaign}', 'CampaignController@update');
    Route::delete('/campaigns/{campaign}', 'CampaignController@delete');

    // Trackers
    Route::get('/{brand}/trackers', 'TrackerController@fetchByBrand');
    Route::get('/{brand}/trackers/search/{query}', 'TrackerController@search');
    Route::get('/{brand}/trackers/{campaign}', 'TrackerController@byCampaign');
    Route::post('/trackers', 'TrackerController@create');
    Route::post('/trackers/story', 'TrackerController@createStory');
    Route::get('/trackers/{tracker}/status', 'TrackerController@changeStatus');
    Route::delete('/trackers/{tracker}', 'TrackerController@delete');
    Route::get('/trackers/{tracker}/analytics', 'TrackerController@analytics');

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
    Route::get('{brand}/influencers', 'InfluencerController@byBrand');
    Route::get('/influencers/{influencer}', 'InfluencerController@show');
    Route::get('/influencers/{influencer}/content', 'InfluencerController@content');
    Route::post('/influencers', 'InfluencerController@create');
    Route::delete('/influencers/{influencer}', 'InfluencerController@delete');

    // Export
    Route::get('/export/excel/{brand}/trackers', 'ExcelExportController@trackers');
});

// Instagram old search
Route::middleware('auth:sanctum')->post('/search', 'SearchController@search');

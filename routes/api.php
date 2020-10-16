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
    Route::put('/brands/{brand}', 'BrandController@update');
    Route::delete('/brands/{brand}', 'BrandController@destroy');
    Route::get('/brands/{brand}/trackers', 'TrackerController@fetchByBrand');

    // Campaigns
    Route::get('/campaigns/{brand}', 'CampaignController@byBrand');
    Route::get('/campaigns/{campaign}/analytics', 'CampaignController@analytics');
    Route::post('/campaigns', 'CampaignController@create');
    Route::delete('/campaigns/{campaign}', 'CampaignController@destroy');

    // Trackers
    Route::post('/trackers', 'TrackerController@create');

    // Users
    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@register');

    // Influencers
    Route::get('/influencers', 'InfluencerController@index');
    Route::get('/influencers/{influencer}', 'InfluencerController@show');
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

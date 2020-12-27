<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/{any}', 'HomeController@index')->where('any', '^(?!api|oauth|u|cdn|websockets/).*$');

Route::post('/oauth', 'AuthenticationController@login')->name('login');

// Short links
Route::get('/u/{code}', 'ShortLinkController@shortenLink')->name('shorten.link');

// CDN routes
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'cdn'], function(){
    // Get influencer or posts local picture
    Route::get('/{entity}/{platform}/{fileType}/{fileName}', function($entity, $platform, $fileType, $fileName){
        return response()->file(Storage::disk('local')->path("{$entity}/{$platform}/{$fileType}/{$fileName}"));
    })->where([
        'entity'    =>  'influencers',
        'platform'  =>  'instagram',
        'fileType'  =>  'pictures|thumbnails'
    ]);
});


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

Route::any('/{any}', 'HomeController@index')->where('any', '^(?!api|oauth|u|websockets/).*$');

Route::post('/oauth', 'AuthenticationController@login')->name('login');

// Short links
Route::get('/u/{code}', 'ShortLinkController@shortenLink')->name('shorten.link');


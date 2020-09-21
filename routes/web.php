<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/login', function () {
//     return view('login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

// Route::get('/test', function () {
//     $response = Http::withHeaders()->get('https://www.instagram.com/alexia_mori__/?__a=1');
//     dd($response->json());
// });


Route::get('/{any}', 'HomeController@index')->where('any', '.*');

Route::post('/login', 'AuthenticationController@login')->name('login');

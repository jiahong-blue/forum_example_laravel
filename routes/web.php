<?php

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

Route::get('/', 'HomeController@index');
// Route::get('/oauth', 'HomeController@index');

// Auth::routes();

/**
 * 社群登入api
 */
Route::get('login/{provider}', 'API\SocialiteController@redirectToProvider');
Route::get('login/{provider}/callback', 'API\SocialiteController@handleProviderCallback');
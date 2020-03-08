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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * board api
 * 只開get
 */
Route::get('boards', 'BoardController@index');
Route::get('board/{id}', 'BoardController@show');

/**
 * Topic api
 */
Route::get('topics/{id}', 'TopicController@index');
Route::get('topic/{id}', 'TopicController@show');
Route::middleware('auth:api')->post('topic', 'TopicController@store');
Route::middleware('auth:api')->put('topic', 'TopicController@store');
Route::middleware('auth:api')->delete('topic/{id}', 'TopicController@destroy');

/**
 * Post api
 * 
 */
Route::middleware('auth:api')->put('post', 'PostController@store');
Route::middleware('auth:api')->post('post', 'PostController@store');
Route::get('post/{id}', 'PostController@show');
Route::middleware('auth:api')->delete('post/{id}', 'PostController@destroy');
Route::get('posts', 'PostController@index');

/**
 * passport api
 */
Route::post('register', 'API\PassportController@register');
Route::post('login', 'API\PassportController@login');


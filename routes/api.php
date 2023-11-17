<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// login route
Route::post('login', 'App\Http\Controllers\Api\AuthController@login');
// register route
Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
// logout route
Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout')->middleware('auth:sanctum');
// news route
Route::get('news', 'App\Http\Controllers\Api\NewsController@index');
// news add route
Route::post('news', 'App\Http\Controllers\Api\NewsController@store')->middleware('auth:sanctum');
// news get detail route
Route::get('news/{id}', 'App\Http\Controllers\Api\NewsController@show');
// news update route
Route::put('news/{id}', 'App\Http\Controllers\Api\NewsController@update')->middleware('auth:sanctum');
// news delete route
Route::delete('news/{id}', 'App\Http\Controllers\Api\NewsController@destroy')->middleware('auth:sanctum');
// news search route
Route::get('news/search/{keyword}', 'App\Http\Controllers\Api\NewsController@search');
// news category route
Route::get('news/category/{category}', 'App\Http\Controllers\Api\NewsController@category');

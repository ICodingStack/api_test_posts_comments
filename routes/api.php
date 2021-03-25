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
//This Route For Question1
Route::get('/TopPosts','postController@TopPosts');
//This Route For Question2
Route::post('/filter','postController@filter');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

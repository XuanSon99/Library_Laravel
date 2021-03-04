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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('user', 'App\Http\Controllers\AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('readers', 'App\Http\Controllers\ReaderController');
    Route::resource('authors', 'App\Http\Controllers\AuthorController');
    Route::resource('publishers', 'App\Http\Controllers\PublisherController');
    Route::resource('languages', 'App\Http\Controllers\LanguageController');
    Route::resource('bills', 'App\Http\Controllers\BillController');
    Route::resource('documents', 'App\Http\Controllers\DocumentController');
    Route::resource('fields', 'App\Http\Controllers\FieldController');
});


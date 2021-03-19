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

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('user', 'App\Http\Controllers\AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('teachers', 'App\Http\Controllers\TeacherController');
    Route::resource('scores', 'App\Http\Controllers\ScoreController');
    Route::resource('subjects', 'App\Http\Controllers\SubjectController');
    Route::resource('classrooms', 'App\Http\Controllers\ClassroomController');
    Route::resource('grade-level', 'App\Http\Controllers\GradeLevelController');
    Route::resource('type-mark', 'App\Http\Controllers\TypeMarkController');
    Route::resource('students', 'App\Http\Controllers\StudentController')->except([
        'show'
    ]);
    Route::get('students/{id}', 'App\Http\Controllers\StudentController@index');
});

<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/', 'ApplicationController@index')->name('list');
Route::get('/create', 'ApplicationController@create')->name('create');
Route::post('/create', 'ApplicationController@store')->name('store');
Route::get('/view/{application}', 'ApplicationController@show')->name('show');
Route::post('/update/{application}', 'ApplicationController@update')->name('update');
Route::get('/close/{application}', 'ApplicationController@close')->name('close');

Route::get('/login/{auth_token}/{application}', 'Auth\LoginController@mailLogin')->name('mail-login');

Route::prefix('manager')->group(function () {
    Route::get('/', 'ManagerApplicationController@index')->name('m-list');
    Route::get('/view/{application}', 'ManagerApplicationController@show')->name('m-show');
    Route::post('/update/{application}', 'ManagerApplicationController@update')->name('m-update');
    Route::get('/close/{application}', 'ManagerApplicationController@close')->name('m-close');
});

Route::get('/mail', function () {
    $application = \App\Application::first();
    $token = \App\AuthToken::create([
       'token' => \Illuminate\Support\Str::random(128),
       'user_id' => Auth::user()->id
    ]);
    return new \App\Mail\NewMessageFromUser($application, $token);
});

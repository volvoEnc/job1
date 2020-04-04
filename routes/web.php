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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/add', 'ApplicationController@create')->name('add');
Route::get('/list', 'ApplicationController@index')->name('list');
Route::get('/view/{application}', 'ApplicationController@show')->name('view');
Route::post('/update/{application}', 'ApplicationController@update')->name('update');

Route::prefix('manager')->group(function () {
    Route::get('/', 'ManagerApplicationController@index')->name('m-list');
    Route::get('/view/{application}', 'ManagerApplicationController@show')->name('m-show');
    Route::post('/update/{application}', 'ManagerApplicationController@update')->name('m-update');
});

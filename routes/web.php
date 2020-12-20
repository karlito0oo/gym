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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

//difficulties
Route::resource('/api/difficulties', 'DifficultiesController');
Route::get('/home/difficulties', 'DifficultiesController@pageHome');

//Genres
Route::resource('/api/genres', 'GenresController');
Route::get('/home/genres', 'GenresController@pageHome');
Route::post('/api/genres/fetch', 'GenresController@fetch');

//Genres
Route::resource('/api/readings', 'ReadingsController');
Route::get('/home/readings', 'ReadingsController@pageHome');
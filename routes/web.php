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

//members
Route::resource('/api/members', 'MembersController');
Route::get('/home/members', 'MembersController@pageHome');
Route::patch('/api/members/updateSection/{id}', 'MembersController@updateSection');
Route::patch('/api/members/updateUserType/{id}', 'MembersController@updateUserType');

//Users
Route::resource('/api/users', 'UsersController');
Route::get('/home/users', 'UsersController@pageHome');
Route::post('/api/users/fetch', 'UsersController@fetch');

//Attendances
Route::post('/api/attendances/userAttendanceToday', 'AttendancesController@userAttendanceToday');
Route::post('/api/attendances/timeInOut', 'AttendancesController@timeInOut');

//SchedulesController
Route::resource('/api/schedules', 'SchedulesController');
Route::get('/home/schedules', 'SchedulesController@pageHome');
Route::post('/api/schedules/fetch', 'SchedulesController@fetch');

//Image upload
Route::post('/api/uploadImage/{do}', 'ImageUploadController@index');

//Image upload
Route::get('/home/messages/', 'MessagesController@pageHome');

//Calendar
Route::resource('/api/calendars', 'CalendarsController');
Route::post('/api/calendars/reserve', 'CalendarsController@reserve');
Route::post('/api/calendars/approve', 'CalendarsController@approve');
Route::get('/api/calendars/cancel/{id}', 'CalendarsController@cancel');
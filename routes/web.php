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

//Readings
Route::resource('/api/readings', 'ReadingsController');
Route::get('/home/readings', 'ReadingsController@pageHome');
Route::post('/api/readings/fetch', 'ReadingsController@fetch');

//Sections
Route::resource('/api/sections', 'SectionsController');
Route::get('/home/sections', 'SectionsController@pageHome');
Route::post('/api/sections/fetch', 'SectionsController@fetch');

//Students
Route::resource('/api/students', 'StudentsController');
Route::get('/home/students', 'StudentsController@pageHome');
Route::patch('/api/students/updateSection/{id}', 'StudentsController@updateSection');

//Users
Route::resource('/api/users', 'UsersController');
Route::get('/home/users', 'UsersController@pageHome');
Route::post('/api/users/fetch', 'UsersController@fetch');

//Questions
Route::resource('/api/questions', 'QuestionsController');
Route::get('/home/questions', 'QuestionsController@pageHome');
Route::post('/api/questions/fetch', 'QuestionsController@fetch');

//Activities
Route::resource('/api/activities', 'ActivitiesController');
Route::get('/home/activities', 'ActivitiesController@pageHome');
Route::post('/home/activities/submit-answers', 'ActivitiesController@submitAnswers');
Route::get('/home/activities/activity-result/{activity_id}/{user_id}', 'ActivitiesController@activityResult');
Route::post('/api/activity/isAnswered', 'ActivitiesController@isAnswered');

//Image upload
Route::post('/api/uploadImage/{do}', 'ImageUploadController@index');

//Questions
Route::resource('/api/posts', 'PostsController');
Route::get('/home/posts', 'PostsController@pageHome');
Route::post('/api/posts/fetch', 'PostsController@fetch');
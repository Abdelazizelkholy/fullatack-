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

//Route::get('test', 'TestController@firstMethod');

Route::any('{slug}', function () {
    return view('welcome');
});

Route::post('app/create_tag', 'TagController@addTag');
Route::get('app/get_tags', 'TagController@getTag');
Route::post('app/edit_tag', 'TagController@editTag');
Route::post('app/delete_tag', 'TagController@deleteTag');
Route::post('/app/upload', 'CategoryController@uploadImage');
Route::post('/app/delete_image', 'CategoryController@deleteImage');
Route::post('/app/create_category', 'CategoryController@addCategory');
Route::get('/app/get_category', 'CategoryController@getCategory');
Route::post('/app/edit_category', 'CategoryController@editCategory');


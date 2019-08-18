<?php

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

Route::POST('createTask','TaskController@createTask')->name('createTask');
Route::POST('deleteTask','TaskController@deleteTask')->name('deleteTask');
Route::POST('updateTask','TaskController@updateTask')->name('updateTask');
Route::GET('taskList','TaskController@taskList')->name('taskList');

Route::POST('createList','TaskListController@createList')->name('createList');
Route::POST('deleteList','TaskListController@deleteList')->name('deleteList');
Route::POST('updateList','TaskListController@updateList')->name('updateList');
Route::GET('lists','TaskListController@lists')->name('lists');
Route::GET('list','TaskListController@list')->name('list');

Route::POST('register','UserController@register')->name('register');
Route::POST('login','UserController@login')->name('login');

Route::post('api/jos-proxy', 'Api\JosController@josProxy');

Route::middleware(['auth.token'])->group(function (){
    Route::get('api/orders/fetch', 'Api\JosController@fetchOrder');
    Route::post('auth','TestController@testAuth')->name('auth');

});






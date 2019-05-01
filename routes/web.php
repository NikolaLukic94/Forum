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


Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads','ThreadController@index');
Route::get('/threads/create','ThreadController@create');
Route::get('/threads/{channel}/{thread}','ThreadController@show');
Route::post('threads/create','ThreadController@store');
Route::delete('threads/{channel}/{thread}','ThreadController@destroy');
Route::post('/threads/{channel}/{thread}/replies','RepliesController@store');

Route::post('/replies/{reply}/favorites','FavoritesController@store');

Route::get('/profiles/{user}','ProfilesController@show');
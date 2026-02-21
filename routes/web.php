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
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/movies', 'MovieController@index')->name('movies.index');
    Route::get('/movies/search', 'MovieController@search')->name('movies.search');
    Route::get('/movies/{id}', 'MovieController@show')->name('movies.show');
    
    Route::get('/favorites', 'FavoriteController@index')->name('favorites.index');
    Route::post('/favorites', 'FavoriteController@store')->name('favorites.store');
    Route::delete('/favorites/{id}', 'FavoriteController@destroy')->name('favorites.destroy');
});

Route::get('/language/{locale}', 'LanguageController@switch')->name('language.switch');

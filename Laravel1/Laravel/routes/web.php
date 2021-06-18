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
use illuminate\Http\Request;

Route::get('/', function(){
    return redirect(URL::to('/home'));
});


Route::get('/home', 'HomeController@overview');

Route::post('/search', 'SearchController@search');

Route::post('/searchdate', 'SearchController@datesearch');

Route::get('/categorie', 'SearchController@category');

Route::get('/favoriet/{id}', 'FavoriteController@addfavorites')->middleware('auth');

Route::get('/deletefavo/{id}', 'FavoriteController@deletefavorites')->middleware('auth');

Route::get('/upfavo/{id}', 'FavoriteController@upfavorites')->middleware('auth');

Route::get('/downfavo/{id}', 'FavoriteController@downfavorites')->middleware('auth');

Route::get('/editfavo/{id}', 'FavoriteController@editfavorites')->middleware('auth');

Route::get('/favoriet', 'FavoriteController@overviewfavorites')->middleware('auth');;

Route::get('/dropdown','DropdownController@index');
Route::get('/dropdown-data','DropdownController@data');




Auth::routes();


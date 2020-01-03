<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('home', 'Api\CategoryController@home');
	
	
	
    Route::get('search', 'Api\CategoryController@search');
    Route::post('update_personnalize', 'Api\UserController@updatePersonnalize');
    Route::get('get_personnalize', 'Api\CategoryController@getPersonnalize');
    Route::get('album/audios', 'Api\AlbumController@audios');
    Route::get('playlist/audios', 'Api\PlaylistController@audios');
    Route::get('categories', 'Api\CategoryController@categories');
    Route::get('category/posts', 'Api\CategoryController@getPostsByCategory');
    Route::post('add_to_favorite', 'Api\UserController@add_to_favorite');
    Route::post('remove_from_favorite', 'Api\UserController@remove_from_favorite');
    Route::get('creator', 'Api\CreatorController@creator');
    Route::get('creators', 'Api\CreatorController@creators');
    Route::get('audios', 'Api\AudioController@audios');
    Route::post('user/change_password', 'Api\UserController@change_password');
    Route::post('user/logout', 'Api\UserController@logout');
    Route::get('recommendation', 'Api\CategoryController@recommendation');
    
});
Route::get('get_categories_suggest', 'Api\CategoryController@getCategoriesSuggest');
Route::post('user/register', 'Api\UserController@register');
Route::post('user/login', 'Api\UserController@login');
Route::post('user/login_facebook', 'Api\UserController@login_facebook');
Route::post('user/login_google', 'Api\UserController@login_google');



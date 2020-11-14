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


//user routing 
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::get('logout', 'Api\AuthController@logout');

//post routing
Route::post('posts/create', 'Api\PostsController@create')->middleware('jwtAuth');
Route::post('posts/delete', 'Api\PostsController@delete')->middleware('jwtAuth');
Route::post('posts/update', 'Api\PostsController@update')->middleware('jwtAuth');
Route::get('posts', 'Api\PostsController@posts')->middleware('jwtAuth');

//comment routing
Route::post('comments/create', 'Api\CommentsController@create')->middleware('jwtAuth');
Route::post('comments/delete', 'Api\CommentsController@delete')->middleware('jwtAuth');
Route::post('comments/update', 'Api\CommentsController@update')->middleware('jwtAuth');
Route::post('posts/comments', 'Api\CommentsController@comments')->middleware('jwtAuth');

//like 
Route::post('posts/like', 'Api\LikesController@like')->middleware('jwtAuth');
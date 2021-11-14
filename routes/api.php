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

Route::get('pockets', 'PocketsController@getPockets')->name('get-pockets');
Route::post('pocket-create', 'PocketsController@createPocket')->name('create-pocket');

Route::get('contents/{pocket_id}', 'ContentsController@getContents');
Route::post('content-create', 'ContentsController@createContent')->name('content-create');
Route::get('content-search', 'ContentsController@getContentByHashTag')->name('content-search');
Route::get('content-delete/{content_id}', 'ContentsController@deleteContent')->name('content-delete');



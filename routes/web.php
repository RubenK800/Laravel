<?php

use App\Http\Controllers\Email;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users;

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

Route::match(['get','post'],'/', 'App\Http\Controllers\Users@index');

Route::get('logout', 'App\Http\Controllers\Users@logout');
Route::match(['get','post'],'register', 'App\Http\Controllers\Users@register', ['filter' => 'noAuth']);
Route::match(['get','post'],'profile', 'App\Http\Controllers\Users@profile',['filter' => 'auth']);
Route::match(['get','post'],'verify', 'App\Http\Controllers\Users@verify');
Route::get('dashboard', 'App\Http\Controllers\Dashboard@index',['filter' => 'auth']);
Route::match(['get','post'], 'album-directory','App\Http\Controllers\Dashboard@setNewAlbumDirectory');
Route::match(['get','post'], 'albums','App\Http\Controllers\Albumphotos@index');
Route::match(['get','post'], 'albums-get','App\Http\Controllers\Albumphotos@albumNames');
Route::match(['get','post'],'get-photos','App\Http\Controllers\Albumphotos@getAlbumPhotos');
Route::match(['get','post'], 'delete-photos','App\Http\Controllers\Users@deleteAlbumPhotos');
Route::match(['get','post'], 'delete-albums','App\Http\Controllers\Users@deleteAlbums');
Route::match(['get','post'], 'other-users-albums','App\Http\Controllers\Users@otherUsersAlbums');
Route::match(['get','post'], 'selected-user-profile','App\Http\Controllers\Users@getUserInfo');
Route::match(['get','post'],'load-other-user-photos','App\Http\Controllers\Albumphotos@getOtherUsersAlbumPhotos');
Route::match(['get','post'],'users-to-chat','App\Http\Controllers\Messages@getUsersForChatting');
Route::match(['get','post'],'open-chat','App\Http\Controllers\Messages@openChat');
Route::match(['get','post'],'store-ms-db','App\Http\Controllers\Messages@storeMessagesInDB');
Route::match(['get','post'],'upload-new-album-image','App\Http\Controllers\Users@uploadAlbumImage');
Route::match(['get','post'],'upload-avatar','App\Http\Controllers\Users@uploadAvatar');
Route::get('/send-email',[Email::class,'sendEmail']);

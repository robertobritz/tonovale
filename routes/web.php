<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

route::post('att-profile', 'User\UserController@profileUpdate')->name('profile.update')->middleware('auth');
route::get('profile', 'User\UserController@profile')->name('profile')->middleware('auth');

Route::get('resizeimage', 'ImageController@resizeImage')->name('resizeimage');
Route::any('resizeimagepost', 'ImageController@resizeImagePost')->name('resizeimage2');
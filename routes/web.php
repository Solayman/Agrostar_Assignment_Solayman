<?php

use Illuminate\Support\Facades\Route;

// Auth::routes(['register' => false]);
Auth::routes();
Route::get('/home', 'HomeController@index')
->middleware('auth')
->name('home');
Route::get('/', 'homeController@index');









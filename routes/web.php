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
    return view('index');
});
/* 
 ----------------------------------------------------------------------
|These routes are auto-generated by the command: php artisan make:auth |
 ----------------------------------------------------------------------
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

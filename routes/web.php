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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/','HomeController@index');

Route::get('/get-information-web','HomeController@getInformationWebsite')->name('getInformationWebsite');
Route::get('/get-top-500','HomeController@getTop500')->name('getTop500');

Auth::routes();


//Admin
Route::group(['prefix'=>'admin'],function (){
   Route::get('/','Admin\AdminController@index')->name('home_admin');
});



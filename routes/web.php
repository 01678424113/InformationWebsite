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
Route::get('/information-website','HomeController@informationWebsite')->name('informationWebsite');

Route::get('/get-information-web','HomeController@getInformationDomain')->name('getInformationDomain');
Route::get('/get-top-500','HomeController@getTop500')->name('getTop500');

Auth::routes();


//Admin
Route::group(['prefix'=>'admin'],function (){
   Route::get('/','Admin\AdminController@index')->name('home_admin');
    //Top 500
   Route::get('/list-top-500','Admin\Top500Controller@listTop500')->name('listTop500');
    //Domain
    Route::get('/list-domain','Admin\DomainController@listDomain')->name('listDomain');
    Route::get('/information-domain','Admin\DomainController@informationDomain')->name('informationDomain');
    //Setting
    Route::get('/list-setting-domain','Admin\SettingController@listSettingDomain')->name('listSettingDomain');
    Route::get('/add-setting-domain','Admin\SettingController@getAddSettingDomain')->name('getAddSettingDomain');
    Route::post('/add-setting-domain','Admin\SettingController@postAddSettingDomain')->name('postAddSettingDomain');

    Route::get('/list-setting-index','Admin\SettingController@listSettingIndex')->name('listSettingIndex');
    Route::get('/add-setting-index','Admin\SettingController@getAddSettingIndex')->name('getAddSettingIndex');
    Route::post('/add-setting-index','Admin\SettingController@postAddSettingIndex')->name('postAddSettingIndex');

    Route::get('/list-setting-view','Admin\SettingController@listSettingView')->name('listSettingView');
    Route::get('/add-setting-view','Admin\SettingController@getAddSettingView')->name('getAddSettingView');
    Route::post('/add-setting-view','Admin\SettingController@postAddSettingView')->name('postAddSettingView');

    Route::get('/list-setting-keyword','Admin\SettingController@listSettingKeyword')->name('listSettingKeyword');
    Route::get('/add-setting-keyword','Admin\SettingController@getAddSettingKeyword')->name('getAddSettingKeyword');
    Route::post('/add-setting-keyword','Admin\SettingController@postAddSettingKeyword')->name('postAddSettingKeyword');

    Route::get('/edit-setting/{setting_id}','Admin\SettingController@getEditSetting')->name('getEditSetting');
    Route::post('/edit-setting/{setting_id}','Admin\SettingController@postEditSetting')->name('postEditSetting');
    Route::get('/delete-setting/{setting_id}','Admin\SettingController@deleteSetting')->name('deleteSetting');
});




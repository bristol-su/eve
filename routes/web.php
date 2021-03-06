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


use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', 'GuestController@index')->name('guest');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/availability', 'AvailabilityController@index')->name('availability');
Route::get('/eventsearch', 'EventSearchController@index')->name('eventsearch');
Route::get('/codereadr', 'CodeReadrController@index')->name('codereadr');
Route::get('/view/{airtable_view}', 'AirtableViewController@show')->name('view');

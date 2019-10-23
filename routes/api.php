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

Route::middleware('auth:api')->get('/events', 'Api\EventController@index');


Route::middleware('auth:api')->get('/availability', 'Api\AvailabilityController@index');
Route::middleware('auth:api')->get('/pencils', 'Api\PencilController@index');
Route::middleware('auth:api')->get('/uc_events/search', 'Api\UcEventsController@search');
Route::middleware('auth:api')->post('/uc_events/{uc_event}/track', 'Api\UcEventsController@track');
Route::middleware('auth:api')->get('/uc_events/track', 'Api\UcEventsController@indexTrack');

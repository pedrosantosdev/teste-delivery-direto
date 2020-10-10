<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/city/create', 'CityController@create');
Route::post('/city/create', 'CityController@store');
Route::get('/city/distance', 'CityController@index');
Route::post('/city/distance', 'VertexController@calculateRouteBetweenTwoPoints');
Route::get('/vertexs', 'VertexController@index');

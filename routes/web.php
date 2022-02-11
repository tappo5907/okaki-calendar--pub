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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['middleware' => 'auth.basic'], function() {
    Route::get('/', 'CareController@index')->name('care.index');
    Route::get('/{year}/{month}', 'CareController@index');
    
    Route::group(['prefix' => 'care/'], function() {
        Route::get('create/{year}/{month}/{day}', 'CareController@create')->name('care.create');
        Route::post('store', 'CareController@store')->name('care.store');
        Route::get('{id}/edit', 'CareController@edit')->name('care.edit');
        Route::put('{id}/update', 'CareController@update')->name('care.update');
        Route::delete('{id}/destroy', 'CareController@destroy')->name('care.destroy');
    });

    Route::group(['prefix' => 'food_weight/'], function() {
        Route::get('/', 'FoodWeightController@index')->name('food_weight.index');
        Route::get('{year}/{month}/{day}', 'FoodWeightController@index')->name('food_weight.index');
    });
});

Route::group(['middleware' => ['api', 'auth:api']], function() {
    Route::post('api/food_weight', 'Api\FoodWeightController@store')->name('api.food_weight.store');
});
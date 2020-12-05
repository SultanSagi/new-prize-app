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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('prizes', 'PrizesController@show');

Route::delete('prizes/{prize}', 'PrizesController@destroy');

Route::get('lotteries', 'LotteriesController@index');

Route::post('user-account', 'UserAccountController@store');

Route::post('money-to-points', 'UserAccountController@convertMoneyToPoints');

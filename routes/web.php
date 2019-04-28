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

Route::get('halo', function () {
	return "Halo, Selamat Datang Di FHQ An-nashr";
});

Route::get('lembaga', 'LembagaController@index');

Route::get('santri', 'SantriController@index');

Route::get('pengajar', 'PengajarController@getAll');

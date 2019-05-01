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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('halo', function () {
	return "Halo, Selamat Datang Di FHQ An-nashr";
});

Route::get('/', 'JwtLoginController@showLoginForm');
Route::get('login', 'JwtLoginController@showLoginForm');
Route::post('login', 'JwtLoginController@login')->name('login');

Route::get('lembaga', 'LembagaController@index');

Route::get('santri', 'SantriController@index');

Route::get('pengajar', 'PengajarController@index');
Route::get('pengajar/{id}', 'PengajarController@show');
Route::delete('pengajar/remove/{id}', 'PengajarController@destroy');

Route::get('semester/{reference}', 'SemesterController@detail');
Route::get('semester', 'SemesterController@index');

Route::get('program', 'ProgramController@index');
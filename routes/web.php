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

Route::group(['middleware' => ['jwtoken']], function () {
	
	/**
	 * Lembaga
	 */
	Route::get('lembaga', 'LembagaController@index');
	Route::get('lembaga/add', 'LembagaController@showFormAdd');
	Route::post('lembaga/postadd', 'LembagaController@add');
	Route::delete('lembaga/remove/{id}', 'LembagaController@remove');
	Route::get('lembaga/detail/{id}', 'LembagaController@detail');
	Route::get('lembaga/{reference}/semester', 'SemesterController@index');

	/**
	 * Santri
	 */
	Route::get('santri', 'SantriController@index');

	/**
	 * Pengajar
	 */
	Route::get('pengajar', 'PengajarController@index');
	Route::get('pengajar/{id}', 'PengajarController@show');
	Route::delete('pengajar/remove/{id}', 'PengajarController@destroy');

	/**
	 * Semester
	 */
	Route::get('semester/add', 'SemesterController@add');
	Route::post('semester/add', 'SemesterController@update');
	Route::delete('semester/remove/{reference}', 'SemesterController@remove');
	Route::get('semester/{reference}', 'SemesterController@detail');
	Route::put('semester/{reference}', 'SemesterController@update');
	Route::get('semester', 'SemesterController@index');
	Route::get('semester/{reference}/halaqoh', 'HalaqohController@lists');

	/**
	 * Program
	 */
	Route::get('program', 'ProgramController@index');

	/**
	 * Halaqoh
	 */
	Route::get('halaqoh/add', 'HalaqohController@add');
	Route::post('halaqoh/add', 'HalaqohController@save');
	Route::get('halaqoh/edit/{reference}', 'HalaqohController@detail');
	Route::put('halaqoh/edit/{reference}', 'HalaqohController@save');

});
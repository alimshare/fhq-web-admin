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

Auth::routes();

Route::group(['middleware' => []], function () {

	// Route::get('halo', function () {
	// 	return "Halo, Selamat Datang Di FHQ An-nashr";
	// });

	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index')->name('home');
	
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
	Route::get('santri/edit/{id}', 'SantriController@edit');
	Route::post('santri/save', 'SantriController@save');

	/**
	 * Pengajar
	 */
	Route::get('pengajar', 'PengajarController@index');
	Route::get('pengajar/{id}', 'PengajarController@show');
	Route::get('pengajar/edit/{id}', 'PengajarController@edit');
	Route::post('pengajar/save', 'PengajarController@save');
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
	Route::get('halaqoh', 'HalaqohController@lists');
	Route::delete('halaqoh/remove', 'HalaqohController@remove');
	Route::get('halaqoh/add', 'HalaqohController@add');
	Route::post('halaqoh/add', 'HalaqohController@save');
	Route::get('halaqoh/{reference}', 'HalaqohController@detail');
	Route::get('halaqoh/{reference}/edit', 'HalaqohController@editDetail');
	Route::put('halaqoh/{reference}', 'HalaqohController@save');
	Route::post('halaqoh-detail/save', 'HalaqohController@saveDetail');


	/**
	 * Change Password
	 */
	Route::get('/change-password', 'HomeController@changePassword');
	Route::post('/change-password', 'HomeController@changePasswordProcess');

});

Route::get('halaqoh-27', 'PublicController@index');


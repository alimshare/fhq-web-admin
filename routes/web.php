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

	Route::get('/', 'HomeController@profile')->name('home');
	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::get('/profile/edit', 'HomeController@profile_edit')->name('profile.edit');
	Route::post('/profile/edit', 'HomeController@profile_edit_save')->name('profile.edit.save');

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
	Route::get('santri', 'SantriController@index')->name('santri.index')->middleware(['permission:list-santri']);
	Route::get('santri/edit/{id}', 'SantriController@edit')->middleware(['permission:edit-santri']);
	Route::post('santri/save', 'SantriController@save')->middleware(['permission:edit-santri']);

	/**
	 * Pengajar
	 */
	Route::get('pengajar', 'PengajarController@index')->middleware(['permission:list-pengajar']);
	Route::get('pengajar/{id}', 'PengajarController@show')->middleware(['permission:detail-pengajar']);
	Route::get('pengajar/edit/{id}', 'PengajarController@edit')->middleware(['permission:edit-pengajar']);
	Route::post('pengajar/save', 'PengajarController@save')->middleware(['permission:add-pengajar']);
	Route::delete('pengajar/remove/{id}', 'PengajarController@destroy')->middleware(['permission:delete-pengajar']);

	/**
	 * Semester
	 */
	Route::get('semester/add', 'SemesterController@add');
	Route::post('semester/add', 'SemesterController@update');
	Route::delete('semester/remove/{reference}', 'SemesterController@remove')->middleware(['permission:delete-pengajar']);;
	Route::get('semester/{reference}', 'SemesterController@detail')->middleware(['permission:detail-pengajar']);;
	Route::put('semester/{reference}', 'SemesterController@update')->middleware(['permission:edit-pengajar']);;
	Route::get('semester', 'SemesterController@index')->middleware(['permission:list-semester']);
	Route::get('semester/{reference}/halaqoh', 'HalaqohController@lists');

	/**
	 * Program
	 */
	Route::get('program', 'ProgramController@index');

	/**
	 * Halaqoh
	 */
	Route::get('halaqoh', 'HalaqohController@lists')->name('halaqoh.index')->middleware(['permission:list-halaqoh']);
	Route::delete('halaqoh/remove', 'HalaqohController@remove');
	Route::get('halaqoh/add', 'HalaqohController@add');
	Route::post('halaqoh/add', 'HalaqohController@save');
	Route::get('halaqoh/{reference}', 'HalaqohController@detail')->middleware(['permission:detail-halaqoh']);
	Route::get('halaqoh/{reference}/edit', 'HalaqohController@editDetail')->middleware(['permission:input-nilai']);
	Route::put('halaqoh/{reference}', 'HalaqohController@save');
	Route::post('halaqoh-detail/save', 'HalaqohController@saveDetail')->middleware(['permission:input-nilai']);


	/**
	 * Change Password
	 */
	Route::get('/change-password', 'HomeController@changePassword');
	Route::post('/change-password', 'HomeController@changePasswordProcess');


    /**
     * Role & Permission
     */
    Route::get('/role/{id?}', 'RolePermissionController@index');
    Route::post('/role/save', 'RolePermissionController@save');

});

Route::get('halaqoh-27', 'PublicController@index');
// Route::view('register', 'auth.register')->name('register');


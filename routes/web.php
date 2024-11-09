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

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HalaqohController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SemesterController;

Auth::routes();

Route::group(['middleware' => []], function () {

	// Route::get('halo', function () {
	// 	return "Halo, Selamat Datang Di FHQ An-nashr";
	// });

	Route::get('/', 'HomeController@profile');
	Route::get('/home', 'HomeController@profile')->name('home');
	Route::get('/dashboard', 'HomeController@index')->name('dashboard');
	Route::get('/admin/clear-cache/{key?}', 'HomeController@clearCache')->name('clear.cache');

	Route::get('/rekap-nilai', [HomeController::class, 'rekapNilai'])->name('rekap.nilai')->middleware(['permission:rekap-nilai.view']);
	Route::get('/rekap-nilai/download', 'HomeController@exportRekapNilai')->name('rekap.nilai.download')->middleware(['permission:rekap-nilai.download']);
	
	Route::get('/rekap-kbm', 			'AbsensiController@rekapKBM')->name('rekap.kbm')->middleware(['permission:rekap-kbm.view']);
	Route::get('/rekap-kbm/download', 	'AbsensiController@exportRekapKBM')->name('rekap.kbm.download')->middleware(['permission:rekap-kbm.download']);

	Route::get('/rekap-kehadiran', 	'HomeController@rekapKehadiran')->name('rekap.kehadiran');//->middleware(['permission:rekap-nilai.view']);

	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::get('/profile/edit', 'HomeController@profile_edit')->name('profile.edit');
	Route::post('/profile/edit', 'HomeController@profile_edit_save')->name('profile.edit.save');

	/**
	 * Absensi KBM
	 */
	Route::get('/absensi', 			 	[AbsensiController::class, 'absensi'])->name('absensi');
	Route::get('/absensi/add', 		 	[AbsensiController::class, 'absensi_form'])->name('absensi.add');
	Route::post('/absensi/save', 	 	[AbsensiController::class, 'save'])->name('absensi.save');
	Route::get('/absensi/edit/{id}', 	[AbsensiController::class, 'edit'])->name('absensi.edit');
	Route::post('/absensi/update',	 	[AbsensiController::class, 'update'])->name('absensi.update');
	Route::get('/absensi/remove/{id}', 	[AbsensiController::class, 'remove'])->name('absensi.remove');

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
	Route::get('santri/add', 'SantriController@add')->middleware(['permission:add-santri']);
	Route::get('santri/edit/{id}', 'SantriController@edit')->middleware(['permission:edit-santri']);
	Route::post('santri/save', 'SantriController@save')->middleware(['permission:edit-santri']);
	Route::get('santri/profile/{santriId}', 'SantriController@profile')->name('santri.profile');//->middleware(['permission:profile-santri']);

	Route::get('peserta/{pesertaId}', 'SantriController@mutabaah')->name('santri.mutabaah');//->middleware(['permission:profile-santri']);

	/**
	 * Pengajar
	 */
	Route::get('pengajar', 					[PengajarController::class, 'index'])->name('pengajar')->middleware(['permission:list-pengajar']);
	Route::get('pengajar/add', 				[PengajarController::class, 'add'])->name('pengajar.add')->middleware(['permission:add-pengajar']);
	Route::post('pengajar/add', 			[PengajarController::class, 'addPost'])->name('pengajar.add')->middleware(['permission:add-pengajar']);

	Route::get('pengajar/{id}', 			[PengajarController::class, 'show'])->middleware(['permission:detail-pengajar']);
	Route::get('pengajar/edit/{id}', 		[PengajarController::class, 'edit'])->middleware(['permission:edit-pengajar']);
	Route::post('pengajar/save', 			[PengajarController::class, 'save'])->middleware(['permission:add-pengajar']);
	Route::delete('pengajar/remove/{id}', 	[PengajarController::class, 'destroy'])->middleware(['permission:delete-pengajar']);

	/**
	 * Semester
	 */
	Route::get('semester/add', 'SemesterController@add');
	Route::post('semester/add', 'SemesterController@update');
	Route::delete('semester/remove/{reference}', 'SemesterController@remove')->middleware(['permission:delete-pengajar']);;
	Route::get('semester/{reference}', 'SemesterController@detail')->middleware(['permission:detail-pengajar']);;
	Route::put('semester/{reference}', 'SemesterController@update')->middleware(['permission:edit-pengajar']);;
	Route::get('semester', 'SemesterController@index')->name('semester.index')->middleware(['permission:list-semester']);
	Route::get('semester/{reference}/halaqoh', 'HalaqohController@lists');

	Route::prefix('semester')->name('semester')->group(function(){
		Route::get('', [SemesterController::class, 'index']);
	});

	/**
	 * Program
	 */
	Route::get('program', 'ProgramController@index')->name('program.index')->middleware(['permission:list-program']);;

	/**
	 * Halaqoh
	 */
	Route::get('halaqoh', 'HalaqohController@lists')->name('halaqoh.index')->middleware(['permission:list-halaqoh']);
	Route::delete('halaqoh/remove', 'HalaqohController@remove');
	Route::get('halaqoh/add', 'HalaqohController@add')->name('halaqoh.add');
	Route::get('halaqoh/manage', 'HalaqohController@manage')->name('halaqoh.manage');
	Route::post('halaqoh/add', 'HalaqohController@save')->name('halaqoh.addPost');

	Route::get('halaqoh/{halaqohReference?}/edit-data', 'HalaqohController@editView')->name('halaqoh.edit');
	Route::post('halaqoh/{halaqohReference?}/edit-data', 'HalaqohController@editPost')->name('halaqoh.editPost');

	Route::get('halaqoh/pindah/{halaqohId?}/{pesertaId?}', 'HalaqohController@pindah')->name('halaqoh.pindah')->middleware(['permission:edit-halaqoh']);
	Route::post('halaqoh/pindah', 'HalaqohController@pindahPost')->name('halaqoh.pindahPost')->middleware(['permission:edit-halaqoh']);

	Route::get('halaqoh/peserta/add/{halaqohId?}', 'HalaqohController@addPeserta')->name('halaqoh.peserta.add')->middleware(['permission:edit-halaqoh']);
	Route::post('halaqoh/peserta/add', 'HalaqohController@addPesertaPost')->name('halaqoh.peserta.addPost')->middleware(['permission:edit-halaqoh']);
	
	Route::get('halaqoh/peserta/cuti', 		[HalaqohController::class, 'cuti'])->name('halaqoh.peserta.cuti')->middleware(['permission:edit-halaqoh']);
	Route::post('halaqoh/peserta/cuti', 	[HalaqohController::class, 'cuti'])->middleware(['permission:edit-halaqoh']);
	Route::get('halaqoh/peserta/restore/{pesertaId?}', 	[HalaqohController::class, 'cutiRestore'])->name('halaqoh.peserta.cuti.restore')->middleware(['permission:edit-halaqoh']);

	Route::get('halaqoh/{reference}', 'HalaqohController@detail')->middleware(['permission:detail-halaqoh']);
	Route::get('halaqoh/{reference}/edit', 'HalaqohController@editDetail')->middleware(['permission:input-nilai']);
	Route::put('halaqoh/{reference}', 'HalaqohController@save');
	Route::post('halaqoh-detail/save', 'HalaqohController@saveDetail')->middleware(['permission:input-nilai']);
	Route::get('/raport-peserta/{pesertaId?}', 'HalaqohController@viewRaport')->name('peserta.raport.print');

	/**
	 * Change Password
	 */
	Route::get('/change-password', 	[UserController::class, 'changePassword']);
	Route::post('/change-password', [UserController::class, 'changePasswordProcess']);


    /**
     * Role & Permission
     */
    Route::get('/role/{id?}', 'RolePermissionController@index')->name('role');
    Route::post('/role/save', 'RolePermissionController@save')->name('role.save');
    Route::post('/user-role/save', 'RolePermissionController@userRoleSave')->name('user-role.save')->middleware(['permission:user-role.save']);
	Route::get('/user-role/remove/{userId}/{roleId}', 'RolePermissionController@userRoleRemove')->name('user-role.remove')->middleware(['permission:user-role.remove']);
    Route::get('/permissions', 'RolePermissionController@permissions')->name('permissions');
    Route::view('/permissions/add', 'pages.permission.form')->name('permissions.add');
    Route::post('/permissions/save', 'RolePermissionController@permissionsPost')->name('permissions.save');

	Route::get('/users', 							[UserController::class, 'index'])->name('users')->middleware(['permission:users']);
	Route::get('/users/add', 						[UserController::class, 'add'])->name('users.add')->middleware(['permission:users']);
	Route::post('/users/add', 						[UserController::class, 'create'])->name('users.add')->middleware(['permission:users']);
	Route::get('/users/reset-password/{userId}',	[UserController::class, 'resetPassword'])->name('users.reset-password')->middleware(['permission:users.reset-password']);

});

Route::get('halaqoh-25', 'PublicController@halaqoh25');
Route::get('halaqoh-26', 'PublicController@halaqoh26');
Route::get('halaqoh-27', 'PublicController@halaqoh27');
Route::get('halaqoh-28', 'PublicController@halaqoh28');
Route::get('halaqoh-29', 'PublicController@halaqoh29');
Route::get('halaqoh-30', 'PublicController@halaqoh30');
Route::get('halaqoh-31', 'PublicController@halaqoh31');
Route::get('halaqoh-32', 'PublicController@halaqoh32');
Route::get('halaqoh-33', 'PublicController@halaqoh33');

Route::get('halaqoh-info/{semesterId}', [PublicController::class, 'halaqohInfo']);
// Route::view('register', 'auth.register')->name('register');

Route::get('/version', function(){
	return env('APP_VERSION', '1.0.0');
});

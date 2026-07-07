<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/halaqoh/{halaqohReference?}/peserta', 'Api\DataController@getPesertaHalaqoh');
Route::get('/peserta/{pesertaReference}/pindah/{halaqohReference}', 'Api\DataController@pindahHalaqoh');
Route::get('/datatable/halaqoh', 'Api\DataController@datatableHalaqoh');
Route::get('/datatable/peserta', 'Api\DataController@datatablePeserta');

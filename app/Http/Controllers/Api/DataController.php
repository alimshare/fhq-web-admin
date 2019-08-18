<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
	function getPesertaHalaqoh($halaqohReference = "") {
		$peserta = \App\Model\View\ViewPeserta::select('peserta_reference','santri_name')->where('halaqoh_reference', $halaqohReference)->get();
		return response()->json($peserta);
	}
}

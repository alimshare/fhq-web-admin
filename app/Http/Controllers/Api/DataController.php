<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
	function getPesertaHalaqoh($halaqohReference = "") {
		$peserta = \App\Model\View\ViewPeserta::select('peserta_reference','santri_name','santri.gender', 'program_name', 'jenis_kbm', DB::raw("TIMESTAMPDIFF( YEAR, santri.birth_date, CURDATE( ) ) AS umur"))
			->leftJoin('santri', 'santri.id', 'view_peserta.santri_id')
			->where('halaqoh_reference', $halaqohReference)
			->orderBy('santri.gender')
			->orderBy('santri.birth_date')
			->get();
		return response()->json($peserta);
	}
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Halaqoh;
use App\Model\Peserta;
use Exception;
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

	function pindahHalaqoh(Request $request, $pesertaReference, $halaqohReference) {
		$peserta = Peserta::where('reference', $pesertaReference)->first();
		if (!$peserta) {
			return response()->json(['error' => 'Peserta not found'], 404);
		}

		$halaqohTujuan = Halaqoh::where('reference', $halaqohReference)->first();
		if (!$halaqohTujuan) {
			return response()->json(['error' => 'Halaqoh Target not found'], 404);
		}

		try{
			$peserta->halaqoh_id = $halaqohTujuan->id;
			$peserta->save();
			return response()->json(['status' => 'ok'], 201);
		} catch(Exception $e){
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}
}

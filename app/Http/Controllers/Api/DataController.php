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

	function datatableHalaqoh(Request $request) {
		$draw = (int) $request->get('draw', 1);
		$start = (int) $request->get('start', 0);
		$length = (int) $request->get('length', 25);
		$search = $request->input('search.value', '');

		$columns = ['semester_name','day','gender','program_name','pengajar_name'];

		$query = \App\Model\View\ViewHalaqoh::query();
		$totalRecords = (clone $query)->count();

		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('semester_name', 'like', "%{$search}%")
				  ->orWhere('day', 'like', "%{$search}%")
				  ->orWhere('program_name', 'like', "%{$search}%")
				  ->orWhere('pengajar_name', 'like', "%{$search}%");
			});
		}

		// Column-specific filtering
		$genderMap = ['IKHWAN' => 'MALE', 'AKHWAT' => 'FEMALE'];
		for ($i = 0; $i < count($columns); $i++) {
			$colSearch = $request->input("columns.{$i}.search.value", '');
			if (!empty($colSearch)) {
				if ($columns[$i] === 'gender') {
					$colSearch = $genderMap[strtoupper($colSearch)] ?? $colSearch;
				}
				$query->where($columns[$i], 'like', "%{$colSearch}%");
			}
		}

		$filteredRecords = (clone $query)->count();

		// Ordering
		$orderCol = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'desc' ? 'desc' : 'asc';
		if (isset($columns[$orderCol])) {
			$query->orderBy($columns[$orderCol], $orderDir);
		}

		$data = $query->skip($start)->take($length)->get();

		return response()->json([
			'draw' => $draw,
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $filteredRecords,
			'data' => $data->map(function ($n) {
				return [
					'semester_name' => $n->semester_name,
					'day' => $n->day,
					'gender' => ($n->gender == 'FEMALE') ? 'AKHWAT' : 'IKHWAN',
					'program_name' => $n->program_name,
					'pengajar_name' => $n->pengajar_name,
					'halaqoh_reference' => $n->halaqoh_reference,
				];
			}),
		]);
	}

	function datatablePeserta(Request $request) {
		$draw = (int) $request->get('draw', 1);
		$start = (int) $request->get('start', 0);
		$length = (int) $request->get('length', 25);
		$search = $request->input('search.value', '');

		$columns = ['semester_name','day','gender_santri','program_name','pengajar_name','nis','santri_name'];

		$query = \App\Model\View\ViewPeserta::query();
		$totalRecords = (clone $query)->count();

		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('santri_name', 'like', "%{$search}%")
				  ->orWhere('pengajar_name', 'like', "%{$search}%")
				  ->orWhere('program_name', 'like', "%{$search}%")
				  ->orWhere('nis', 'like', "%{$search}%")
				  ->orWhere('semester_name', 'like', "%{$search}%");
			});
		}

		// Column-specific filtering
		$genderMap = ['IKHWAN' => 'MALE', 'AKHWAT' => 'FEMALE'];
		for ($i = 0; $i < count($columns); $i++) {
			$colSearch = $request->input("columns.{$i}.search.value", '');
			if (!empty($colSearch)) {
				if ($columns[$i] === 'gender_santri') {
					$colSearch = $genderMap[strtoupper($colSearch)] ?? $colSearch;
				}
				$query->where($columns[$i], 'like', "%{$colSearch}%");
			}
		}

		$filteredRecords = (clone $query)->count();

		// Ordering
		$orderCol = (int) $request->input('order.0.column', 0);
		$orderDir = $request->input('order.0.dir', 'asc') === 'desc' ? 'desc' : 'asc';
		if (isset($columns[$orderCol])) {
			$query->orderBy($columns[$orderCol], $orderDir);
		}

		$data = $query->skip($start)->take($length)->get();

		return response()->json([
			'draw' => $draw,
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $filteredRecords,
			'data' => $data->map(function ($n) {
				return [
					'semester_name' => $n->semester_name,
					'day' => $n->day,
					'gender' => ($n->gender_santri == 'FEMALE') ? 'AKHWAT' : 'IKHWAN',
					'program_name' => $n->program_name,
					'pengajar_name' => $n->pengajar_name,
					'nis' => $n->nis,
					'santri_name' => $n->santri_name,
					'halaqoh_reference' => $n->halaqoh_reference,
					'peserta_reference' => $n->peserta_reference,
				];
			}),
		]);
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

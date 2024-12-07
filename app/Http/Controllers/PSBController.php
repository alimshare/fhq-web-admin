<?php

namespace App\Http\Controllers;

use App\Model\DaftarUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PSBController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    function daftarUlang(Request $request)
    {
        $data['list'] = DaftarUlang::join(DB::raw('view_peserta AS v'), 'v.peserta_id', 'daftar_ulang.peserta_id')
            ->select('daftar_ulang.id', 'daftar_ulang.peserta_id', 'daftar_ulang.hari', 'daftar_ulang.jenis_kbm', 
            'daftar_ulang.upload_file','daftar_ulang.created_at','daftar_ulang.verified_at', 
            'daftar_ulang.tgl_lahir', 'v.nis', 'v.santri_name', 'v.pengajar_name', 'v.program_name')->orderBy('created_at', 'DESC')->get();
            
        $data['days'] = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        
        return view('pages.psb.daftar-ulang.list', $data);
    }

    function formDaftarUlang()
    {
        return view('pages.psb.daftar-ulang.add');
    }

    function daftarUlangSummary(Request $request) {}

    function verify($id) {
        $o = DaftarUlang::find($id);
        $o->verified_at = empty($o->verified_at) ? date('Y-m-d H:i:s') : null;
        $o->save();

        return response()->json(['status'=>'ok']);
    }
}

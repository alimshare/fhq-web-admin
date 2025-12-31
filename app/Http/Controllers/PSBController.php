<?php

namespace App\Http\Controllers;

use App\Model\Daftar\CalonSantri;
use App\Model\DaftarUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
        $semester = !empty($request->semester_id) ?  $request->semester_id : Session::get('semesterActive')->next_semester_id;

        $data['list'] = DaftarUlang::join(DB::raw('view_peserta AS v'), 'v.peserta_id', 'daftar_ulang.peserta_id')
            ->select('daftar_ulang.id', 'daftar_ulang.peserta_id', 'daftar_ulang.hari', 'daftar_ulang.jenis_kbm', 
            'daftar_ulang.upload_file','daftar_ulang.created_at','daftar_ulang.verified_at', 
            'daftar_ulang.tgl_lahir', 'v.nis', 'v.santri_name', 'v.pengajar_name', 'v.program_name','v.status','v.semester_name')
            ->where('next_semester_id', $semester)
            ->orderBy('created_at', 'DESC')
            ->get();
            
        $data['days'] = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        
        if ($request->view == "gallery") {
            return view('pages.psb.daftar-ulang.list-gallery', $data);        
        }

        return view('pages.psb.daftar-ulang.list', $data);
    }

    function editDaftarUlang(Request $request, $id)
    {
        $du = DaftarUlang::with('peserta')->select('daftar_ulang.*')->where('id', $id)->first();
        if (!$du) {
            return redirect()->route('du')->with('alert', ['message'=>"Data DU tidak ditemukan !", 'type'=>'danger']);
        }

        if ($request->method() == "POST") {

            if(isset($request->upload_file)) {

                $uploadFile = $du->upload_file;
                if (Storage::exists("public/daftar-ulang/$uploadFile")) {
                    Storage::delete("public/daftar-ulang/$uploadFile");
                }

                $file = $request->file('upload_file');
                $path = $file->store('/public/daftar-ulang');
                $du->upload_file = $file->hashName();

            } else {
                $du->hari = $request->hari;
                $du->jenis_kbm = $request->jenis_kbm;
                $du->tgl_lahir = $request->tgl_lahir;
            }
                
            if ($du->save()) {
                return redirect()->route('du.edit', ['id'=>$id])->with('alert', ['message'=>'Informasi DU berhasil diperbarui', 'type'=>'success']);
            }

            return redirect()->route('du.edit', ['id'=>$id])->with('alert', ['message'=>'Informasi DU gagal diperbarui', 'type'=>'danger']);

        }

        return view('pages.psb.daftar-ulang.edit', compact('du'));
    }

    function daftarUlangSummary(Request $request) {}

    function verify($id) {
        $o = DaftarUlang::find($id);
        $o->verified_at = empty($o->verified_at) ? date('Y-m-d H:i:s') : null;
        $o->save();

        return response()->json(['status'=>'ok']);
    }

    function removeDaftarUlang(Request $request, $id) 
    {    
        $du = DaftarUlang::with('peserta')->select('daftar_ulang.*')->where('id', $id)->first();
        if (!$du) {
            return redirect()->route('du')->with('alert', ['message'=>"Data DU tidak ditemukan !", 'type'=>'danger']);
        }

        if ($du->delete()) {            
            $uploadFile = $du->upload_file;
            if (Storage::exists("public/daftar-ulang/$uploadFile")) {
                Storage::delete("public/daftar-ulang/$uploadFile");
            }

            return redirect()->route('du', ['id'=>$id])->with('alert', ['message'=>'Informasi DU berhasil dihapus, silahkan hubungi admin untuk pemulihan data jika diperlukan.', 'type'=>'success']);
        }

        return redirect()->route('du')->with('alert', ['message'=>"Data DU gagal dihapus !", 'type'=>'danger']);
    }

    function daftarCalonSantri(Request $request) {
        $daftarSemester = CalonSantri::orderByDesc('semester_psb')->distinct()->pluck('semester_psb');

        $semester = empty($request->semester_id) ?   @$daftarSemester[0] : $request->semester_id;
        
        $calonSantri = CalonSantri::select('calon_santri.registration_number','name','calon_santri.program','calon_santri.is_child',
                'jenis_kbm', 'birth_date', 'gender','day', 'calon_santri.created_at', DB::raw('placement_test.program AS program_pt'), 
                'placement_test.penguji', 'calon_santri.upload_file', 'calon_santri.phone')
            ->leftJoin('placement_test', 'placement_test.registration_number', 'calon_santri.registration_number')
            ->where('semester_psb', $semester)
            ->get();
        
        
        return view('pages.psb.psb.list', compact('daftarSemester', 'calonSantri', 'semester'));
    }
}

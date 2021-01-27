<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Model\Santri;
 
class SantriController extends Controller
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

    //di sini isi controller santri
    public function index(){
    	$this->data['list'] = \App\Model\Santri::all();
        return view('pages.santri.list', $this->data);

    }

    public function add()
    {
        return view('pages.santri.form-add');
    }

    public function edit($id)
    {
        $this->data['santri'] = \App\Model\Santri::find($id);
        return view('pages.santri.form-edit', $this->data);
    }
    
    public function save(Request $request)
    {
        $id     = $request->input('id');
        $name   = $request->input('name');
        $nis    = $request->input('nis');

        $message = "";
        $messageType = "success";
        
        if (!$id) {

            $santri = new \App\Model\Santri;
            $santri->nis    = $nis;
            $santri->name   = $name;

            $santri->gender   = $request->input('gender');
            $santri->phone    = $request->input('phone');

            if ($santri->save()) {
                $message = "simpan data santri berhasil";
            } else {
                $message = "simpan data santri gagal";
                $messageType = "danger";
            }

        } else {

            $santri = \App\Model\Santri::find($id);
            if (is_null($santri)) {
                return redirect('santri');
            }

            $santri->nis    = $nis;
            $santri->name   = $name;

            if ($santri->save()) {
                $message = "ubah data santri berhasil";
            } else {
                $message = "ubah data santri gagal";
                $messageType = "danger";
            }

        }

        return redirect('santri')->with('alert', ['message'=>$message, 'type'=>'success']);
    }

    public function profile(Request $request, $santriId = null)
    {
        $user = Santri::where('id', $santriId)->first();
        $halaqoh = \App\Model\View\ViewPeserta::where('santri_id', $user->id)->orderBy('semester_name','desc')->get();

        $data['profile']  = $user;
        $data['halaqoh']  = $halaqoh;

        return view('pages.profile.profile_santri',$data);
    }
}
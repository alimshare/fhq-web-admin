<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use \App\Model\{Pengajar, Semester};
 
class PengajarController extends Controller
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
    
    /**
     * Public container data.
     * Variable ini untuk memudahkan penampungan data.
     * Jadi, cukup 1 variable ini saja yg di pakai, untuk data yg akan di passing ke view.
     * Cukup kirim $this->data, maka semuanya akan terkirim. Jadi insyaalah tidak ada yg kelewat.
     */

    public $data = array();

    public function index(){
        // $this->data['pengajar'] = Curl::to(env('API_ENDPOINT').'pengajar')
        //     ->withHeaders([
        //         'Content-type: application/x-www-form-urlencoded',
        //         'Authorization: Bearer '.$this->token()
        //     ])
        //     ->asJson()
        //     ->get();

        // return view('pengajar', $this->data);

        $this->data['list'] = \App\Model\Pengajar::all();
        return view('pages.pengajar.list', $this->data);
    }

    function add() {
        return view('pages.pengajar.add', []);
    }

    function addPost(Request $request) {
        $validatedData = $request->validate([
            "name"      => "bail|required|max:255|unique:pengajar,name",
            "phone"     => "required|numeric",
            "gender"    => "required|in:MALE,FEMALE",
        ]);

        $name   = $request->input('name');
        $phone  = $request->input('phone');
        $gender = $request->input('gender');
        $address = $request->input('address');
        
        $o = new Pengajar;
        $o->name = $name;
        $o->phone = $phone;
        $o->gender = $gender;
        $o->address = $address;

        $type = "";
        if ($o->save()) {
            $message = "ubah data pengajar berhasil";
        } else {
            $message = "ubah data pengajar gagal";
            $type = "danger";
        }

        return redirect('pengajar')->with('alert', ['message'=>$message, 'type'=>$type]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile        = Pengajar::find($id);

        $halaqoh = \App\Model\View\ViewHalaqoh::where('pengajar_id', $profile->id)->WithCount(['peserta'])->orderBy('halaqoh_id', 'desc')->get();

        $halaqohAktif = [];
        $halaqohLampau = [];
        foreach ($halaqoh as $row) {
            if ($row->semester_id == Semester::getActive()->id) {
                $halaqohAktif[] = $row;
            } else {
                $halaqohLampau[] = $row;
            }            
        }

        $data['profile']        = $profile;
        $data['halaqoh_aktif']  = $halaqohAktif;
        $data['halaqoh_lampau'] = $halaqohLampau;
        $data['title']          = 'Informasi Pengajar';
        $data['breadcrumb']     = [
            [
                'name' => 'Pengajar', 
                'link' => '/pengajar', 
                'css' => ''
            ],
            [
                'name' => 'Detail', 
                'link' => '', 
                'css' => 'active'
            ],
        ];

        return view('pages.pengajar.view',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->data['pengajar'] = Curl::to(env('API_ENDPOINT').'pengajar'.'/remove/'.$id)
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$this->token()
            ])
            ->asJson()
            ->get();

        return view('pengajardestroy', $this->data);
    }

    public function edit($id)
    {
        $this->data['pengajar'] = \App\Model\Pengajar::find($id);
        return view('pages.pengajar.form-edit', $this->data);
    }
    
    public function save(Request $request)
    {
        $id     = $request->input('id');
        $name   = $request->input('name');
        $nip    = $request->input('nip');

        $pengajar = \App\Model\Pengajar::find($id);
        if (is_null($pengajar)) {
            return redirect('pengajar');
        }

        $pengajar->nip    = $nip;
        $pengajar->name   = $name;

        $message = "";
        if ($pengajar->save()) {
            $message = "ubah data pengajar berhasil";
        } else {
            $message = "ubah data pengajar gagal";
        }

        return redirect('pengajar')->with('message', $message);

    }
}
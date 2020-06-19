<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['pengajar'] = Curl::to(env('API_ENDPOINT').'pengajar'.'/'.$id)
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$this->token()
            ])
            ->asJson()
            ->get();

        return view('pengajar-detail', $this->data);
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
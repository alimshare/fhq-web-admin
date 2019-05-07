<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class LembagaController extends Controller
{
    //di sini isi controller lembaga
    public function index(){
        $token = $this->token();
        $this->data['lembaga'] = Curl::to(env('API_ENDPOINT').'lembaga')
        ->withHeaders(['Content-type: application/json', 'Authorization: Bearer '.$token ])
        ->asJson()
        ->get();

        return view('lembaga', $this->data);
	}

	public function showFormAdd(){
		return view('lembaga_add');
	}

    public function add(Request $request){

    	$nama      = $request->input('nama');
        $telp      = $request->input('telp');
        $alamat    = $request->input('alamat');
        $email	   = $request->input('email');
        $berdiri   = $request->input('berdiri');
        $longitude = $request->input('longitude');
        $latitude  = $request->input('latitude');
        $negara	   = $request->input('negara');
        $propinsi  = $request->input('propinsi');
        $status    = $request->input('status');

        $token = $this->token();
        $addlembaga= Curl::to(env('API_ENDPOINT').'lembaga/add')
        ->withHeaders(['Content-type: application/json', 'Authorization: Bearer '.$token ])
        ->withData([
        	'name' => $nama, 
            'address' => $alamat, 
            'phone' => $telp, 
            'email' => $email,
            'since' => $berdiri,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'country' => $negara,
            'province' => $propinsi,
            'status' => $status
        ])
        ->asJson()
        ->post();
        if ($addlembaga->code == 'SUCCESS') {
            return redirect('/lembaga');
        }else {
        	return redirect('/lembaga/add')->with('message', $addlembaga->message);
        }
	}

    public function detail($id){
        $token = $this->token();
        $this->data['lembaga'] = Curl::to(env('API_ENDPOINT').'lembaga/'.$id)
        ->withHeaders(['Content-type: application/json', 'Authorization: Bearer '.$token ])
        ->asJson()
        ->get();

        return view('lembaga_detail', $this->data);
        //return view('edit_lembaga');
    }

    public function remove($id){

        $token = $this->token();
        $this->data['lembaga'] = Curl::to(env('API_ENDPOINT').'lembaga/remove/'.$id)
        ->withHeaders(['Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$token])
        ->asJson()
        ->delete();
            if($this->data['lembaga']->code == 'SUCCESS'){
                return redirect('lembaga')->with('alert','Berhasil Dihapus');
            }else{
                return view('lembagaremove',$this->data);
            }
    }
}
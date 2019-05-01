<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SemesterController extends Controller
{
    /**
     * Public container data.
     * Variable ini untuk memudahkan penampungan data.
     * Jadi, cukup 1 variable ini saja yg di pakai, untuk data yg akan di passing ke view.
     * Cukup kirim $this->data, maka semuanya akan terkirim. Jadi insyaalah tidak ada yg kelewat.
     */
    public $data = array();

    //di sini isi controller semester
    public function index()
    {
        $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester')
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$this->token()
            ])
            ->asJson()
            ->get();

        return view('semester', $this->data);

	}

    public function detail(Request $Request, $reference=null)
    {
        $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester/'.$reference)
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$this->token()
            ])
            ->asJson()
            ->get();

        // $this->data['reference'] = $reference;

        dd($this->data);

        return view('semester-form', $this->data);

    }

    public function update(Request $request, $reference=null)
    {
        // dd($request->all());
        $send_data = array();
        if ($request->input('description')) 
        {
            $send_data['description'] = $request->input('description');
        }

        if ($request->input('lembaga')) 
        {
            $send_data['lembaga']['name'] = $request->input('lembaga');
        }

        if ($request->input('name')) 
        {
            $send_data['name'] = $request->input('name');
        }

        $send_data['active'] = $request->input('active') == 'on' ? 1 : 0;
        
        $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester/edit/'.$reference)
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$this->token()
            ])
            ->withData( $send_data )
            ->asJson()
            ->put();

        dd($this->data, $send_data);

        return view('semester-form', $this->data);
    }
}
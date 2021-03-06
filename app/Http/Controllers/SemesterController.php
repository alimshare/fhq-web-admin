<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SemesterController extends Controller
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


    public function index(Request $request)
    {
        $this->data['list'] = \App\Model\Semester::orderBy('name','desc')->get();
        return view('pages.semester.list', $this->data);

	}

    public function add(Request $request)
    {
        $this->data['lembaga'] = $this->get_lembaga_list();
        return view('semester-form', $this->data);
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

        $this->data['lembaga'] = $this->get_lembaga_list();

        $this->data['reference'] = $reference;

        // dd($this->data);

        return view('semester-form', $this->data);

    }

    public function update(Request $request, $reference=null)
    {
        $send_data = array();
        if ($request->input('description')) 
        {
            $send_data['description'] = $request->input('description');
        }

        if ($request->input('lembaga')) 
        {
            $send_data['lembaga'] = $request->input('lembaga');
        }

        if ($request->input('name')) 
        {
            $send_data['name'] = $request->input('name');
        }

        $send_data['active'] = $request->input('active') == 'on' ? 1 : 0;
        
        if ($reference) 
        {
            $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester/edit/'.$reference)
                ->withHeaders([
                    'Content-type: application/json',
                    'Authorization: Bearer '.$this->token()
                ])
                ->withData( $send_data )
                ->asJson()
                ->put();

            return redirect('semester/'.$reference);
        }
        else
        {
            $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester/add')
                ->withHeaders([
                    'Content-type: application/json',
                    'Authorization: Bearer '.$this->token()
                ])
                ->withData( $send_data )
                ->asJson()
                ->post();

            // dd($this->data);

            return redirect('semester/');
        }

        // dd($this->data, $send_data);

    }

    public function remove(Request $request, $reference=null)
    {
        // dd($request, $reference);
        $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester/remove/'.$reference)
            ->withHeaders([
                'Content-type: application/json',
                'Authorization: Bearer '.$this->token()
            ])
            // ->withData( $send_data )
            // ->asJson()
            ->delete(); 

        return redirect('semester');
    }

    public function get_lembaga_list()
    {
        return Curl::to(env('API_ENDPOINT').'lembaga')
            ->withHeaders([
                'Content-type: application/json', 
                'Authorization: Bearer '.$this->token()
            ])
            ->asJson()
            ->get();
    }
}
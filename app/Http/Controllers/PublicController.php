<?php

namespace App\Http\Controllers;

use App\Model\DaftarUlang;
use App\Model\Peserta;
use App\Model\Santri;
use App\Model\Semester;
use App\Model\View\ViewHalaqoh;
use App\Model\View\ViewPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public $data = [];

    public function halaqoh25()
    {
        $this->data['list'] = Cache::remember('viewPeserta.25', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri')
                ->where('semester_id', 2)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh26()
    {
        $this->data['list'] = Cache::remember('viewPeserta.26', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri')
                ->where('semester_id', 11)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh27()
    {
        $this->data['list'] = Cache::remember('viewPeserta.27', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri')
                ->where('semester_id', 12)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh28()
    {
        $this->data['list'] = Cache::remember('viewPeserta.28', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri')
                ->where('semester_id', 13)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh29()
    {
        $this->data['list'] = Cache::remember('viewPeserta.29', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri')
                ->where('semester_id', 14)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh30()
    {
        $this->data['list'] = Cache::remember('viewPeserta.30', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri', 'jenis_kbm', 'lokasi_kbm')
                ->where('semester_id', 15)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        return view('info-halaqoh-manual', $this->data);
    }

    public function halaqoh31()
    {
        $this->data['list'] = Cache::remember('viewPeserta.31', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri', 'jenis_kbm', 'lokasi_kbm')
                ->where('semester_id', 31)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        return view('info-halaqoh-manual', $this->data);
    }

    public function halaqoh32()
    {
        $this->data['list'] = Cache::remember('viewPeserta.32', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri', 'jenis_kbm', 'lokasi_kbm')
                ->where('semester_id', 32)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        return view('info-halaqoh-manual', $this->data);
    }

    public function halaqoh33()
    {
        $this->data['list'] = Cache::remember('viewPeserta.33', 60 * 60 * 24 * 7, function () {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri', 'jenis_kbm', 'lokasi_kbm')
                ->where('semester_id', 33)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        return view('info-halaqoh-manual', $this->data);
    }

    public function halaqohInfo($semesterId)
    {
        $this->data['list'] = Cache::remember('viewPeserta.' . $semesterId, 60 * 60 * 24 * 7, function () use ($semesterId) {
            return \App\Model\View\ViewPeserta::select('nis', 'santri_name', 'pengajar_name', 'program_name', 'day', 'gender_santri', 'jenis_kbm', 'lokasi_kbm')
                ->where('semester_id', $semesterId)
                ->orderBy('santri_name', 'asc')
                ->get();
        });
        $this->data['days']     = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));
        return view('info-halaqoh-manual', $this->data);
    }

    function daftarUlang(Request $request, $semester, $hash)
    {
        $data = [];
        $data['semester'] = $semester;

        $validHash = env('PSB_SECURITY_HASH', sha1('fhq.38.du'));

        // if ($hash == "d48bc198e533871aa9e0985c083ab9a56efb8197") {
            // abort(403, "Periode Daftar Ulang sudah berakhir, Silahkan hubungi admin untuk informasi lebih lanjut.");
        // }

        if ($hash != $validHash) {
            abort(403, "Alamat URL tidak valid.");
        }

        if ($request->method() == "POST") {

            $semesterActive = Semester::getActive();

            // Support search by NIS, name, or phone. The confirm step still sends 'nis' as hidden field.
            $query = trim($request->input('search', $request->input('nis', '')));
            $data['search'] = $query;

            if (!$request->filled('confirm') && !$request->filled('santri_id') && mb_strlen($query) < 3) {
                return redirect()->route('public.du.form', ['semester' => $semester, 'hash' => $hash])
                    ->with('alert', ['message' => "Masukkan minimal 3 karakter untuk pencarian.", 'type' => 'danger'])
                    ->withInput();
            }

            $semesterSubquery = function ($q) use ($semester) {
                $q->select('santri_id')
                  ->from('peserta')
                  ->join('view_halaqoh as vh', 'vh.halaqoh_id', '=', 'peserta.halaqoh_id')
                  ->where('vh.semester_id', $semester);
            };

            // If a specific santri_id was chosen from a disambiguation list
            if ($request->filled('santri_id') && !$request->filled('confirm')) {
                // Bug fix: scope to semester so arbitrary santri_id cannot be injected
                $santri = Santri::select('id', 'nis', 'name', 'phone')
                    ->whereIn('id', $semesterSubquery)
                    ->find((int) $request->santri_id);
                if (!$santri) {
                    return redirect()->route('public.du.form', ['semester' => $semester, 'hash' => $hash])
                        ->with('alert', ['message' => "Santri tidak ditemukan!", 'type' => 'danger']);
                }
            } elseif ($request->filled('confirm')) {
                // Bug fix: confirm step carries exact NIS — search by NIS only to avoid wrong-santri via name/phone OR match
                $santri = Santri::select('id', 'nis', 'name', 'phone')
                    ->where('nis', $query)
                    ->whereIn('id', $semesterSubquery)
                    ->first();
                if (!$santri) {
                    return redirect()->route('public.du.form', ['semester' => $semester, 'hash' => $hash])
                        ->with('alert', ['message' => "Santri tidak ditemukan!", 'type' => 'danger']);
                }
            } else {
                // Search by NIS (exact), phone (normalized, contains), or name (contains)
                // scoped to santri who are active peserta in the given semester
                $phoneCore = $this->normalizePhone($query);
                $results = Santri::select('id', 'nis', 'name', 'phone')
                    ->where(function ($q) use ($query, $phoneCore) {
                        $q->where('nis', $query)
                          ->orWhere('name', 'LIKE', "%{$query}%")
                          ->when($phoneCore, fn($q) => $q->orWhere('phone', 'LIKE', "%{$phoneCore}%"));
                    })
                    ->whereIn('id', $semesterSubquery)
                    ->get();

                if ($results->isEmpty()) {
                    return redirect()->route('public.du.form', ['semester' => $semester, 'hash' => $hash])
                        ->with('alert', ['message' => "Santri dengan data <b>" . e($query) . "</b> tidak ditemukan!", 'type' => 'danger'])
                        ->withInput();
                }

                if ($results->count() > 1) {
                    $data['search_results'] = $results;
                    return view('daftar-ulang.form-public', $data);
                }

                $santri = $results->first();
            }

            $data['nis'] = $nis = $santri->nis;

            $halaqohList = Peserta::join(DB::raw('view_halaqoh AS vh'), 'vh.halaqoh_id', 'peserta.halaqoh_id')
                ->leftJoin(DB::raw('daftar_ulang as du'), 'du.peserta_id', 'peserta.id')
                ->where('santri_id', $santri->id)
                ->where('vh.semester_id', $semester)
                ->select(DB::raw('peserta.id AS peserta_id'), 'vh.pengajar_name', 'vh.program_name', 'vh.day', 'vh.jenis_kbm', 'vh.semester_id', 
                    DB::raw('du.id AS daftar_ulang_id'), 'du.verified_at', 'du.next_semester_id')
                ->get();

            if ($halaqohList->count() == 0) {
                return redirect()->route('public.du.form', [
                        'semester'=>$semester, 'hash' => $hash]
                    )->with('alert', ['message'=>"Santri bukan peserta aktif pada Semester <b>$semester</b> !", 'type'=>'danger']);
            }

            $isCompleted = true;
            foreach ($halaqohList as $key => $h) {
                if (empty($h->daftar_ulang_id)) {
                    $isCompleted = false;
                }

                if ($h->next_semester_id != $semesterActive->next_semester_id) {
                    $isCompleted = false;
                }
            }

            $data['santri_name']    = $santri->name;
            $data['phone_masking']  = $this->maskPhoneNumber($santri->phone);
            $data['halaqohList']    = $halaqohList;
            $data['completed']      = $isCompleted;
            $data['semesterActive'] = $semesterActive;

            /** Submit Daftar Ulang Form */
            if (isset($request->confirm)) {

                $validatedData = $request->validate([
                    "peserta_id" => "bail|required",
                    "hari"       => "required|in:SABTU,AHAD,CUTI",
                    "jenis_kbm"  => "required|in:OFFLINE,ONLINE,CUTI",
                    "upload"     => "required|file|max:4096", 
                ]);
                
                $file = $request->file('upload');
                $path = $file->store('/public/daftar-ulang');

                $o = new DaftarUlang;
                $o->peserta_id = $request->peserta_id;
                $o->hari = $request->hari;
                $o->jenis_kbm = $request->jenis_kbm;
                $o->tgl_lahir = $request->tgl_lahir;
                $o->upload_file = $file->hashName();
                $o->next_semester_id = $semesterActive->next_semester_id;

                if ($o->save()) {
                    return redirect()->route('public.du.success');
                }

                return redirect()->route('public.du.form',[
                    'semester'=>$semester, 'hash' => $hash]
                )->with('alert', ['message'=>"Terjadi masalah ketika menyimpan data, Harap hubungi admin untuk informasi lebih lanjut.", 'type'=>'danger']);

            }
        }

        return view('daftar-ulang.form-public', $data);
    }

    function daftarUlangSuccess(Request $request) {
        $ref = @$request->reference;

        return view('daftar-ulang.success');
    }


    /**
     * Strip Indonesian phone prefixes (+62, 62, 0) to get core digits for flexible LIKE matching.
     * Returns null if the input doesn't look like a phone number (not enough digits).
     */
    private function normalizePhone(string $input): ?string
    {
        $digits = preg_replace('/[^0-9]/', '', $input);

        if (strlen($digits) < 7) {
            return null;
        }

        if (str_starts_with($digits, '62')) {
            return substr($digits, 2);
        }

        if (str_starts_with($digits, '0')) {
            return substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Mask a phone number by replacing the middle digits with asterisks.
     *
     * @param string $phoneNumber The original phone number.
     * @return string The masked phone number.
     */
    function maskPhoneNumber($phoneNumber)
    {
        // Validate phone number length (assumes 10 digits for this example)
        if (empty($phoneNumber)) {
            return "<i>Nomor Handphone kosong</i>";
        }

        // Ensure only numbers, dashes, and spaces remain
        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Mask the middle digits
        return str_pad("*", strlen($phoneNumber) - 4, "*") . substr($cleanNumber, -4);
    }
}

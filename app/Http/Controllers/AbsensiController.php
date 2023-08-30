<?php

namespace App\Http\Controllers;

use App\Exports\RekapKbmExport;
use Illuminate\Http\Request;
use \App\Model\Peserta;
use \App\Model\Semester;
use \App\Model\Halaqoh;
use \App\Model\ActivityReport;
use \App\Model\Attendance;

class AbsensiController extends Controller
{

    private $data = [];

    public function absensi(Request $request)
    {
        if (!empty($request->input('halaqohRef'))) 
        {
            $this->data['halaqohId'] = $halaqohId = $request->input('halaqohRef');
            $this->data['kehadiran'] = Attendance::selectRaw('peserta_id, COUNT(1) count_kehadiran')
                ->with('peserta')
                ->whereIn('peserta_id', function ($query) use ($halaqohId) {
                    $query->select('id')->from('peserta')->where('halaqoh_id', $halaqohId)->whereNull('deleted_at');
                })
                ->where('status', 1)
                ->groupBy('peserta_id')
                ->orderBy('count_kehadiran', 'desc')
                ->get();
            $this->data['kbm'] = ActivityReport::where('halaqoh_id', $halaqohId)->with('halaqoh')->withCount(['attendances', 'hadir'])->orderBy('tgl', 'desc')->get();
        } 
        else 
        {
            $profileID = auth()->user()->profile_id;
            $halaqohIds = \App\Model\View\ViewHalaqoh::where('pengajar_id', $profileID)->where('semester_id', Semester::getActive()->id)->pluck('halaqoh_id')->toArray();
            $this->data['kbm']       = ActivityReport::whereIn('halaqoh_id', $halaqohIds)->withCount(['attendances'])->with('halaqoh')->orderBy('tgl', 'desc')->get();
            $this->data['kehadiran'] = Attendance::selectRaw('peserta_id, COUNT(1) count_kehadiran')
                ->with('peserta')
                ->whereIn('peserta_id', function ($query) use ($halaqohIds) {
                    $query->select('id')->from('peserta')->whereIn('halaqoh_id', $halaqohIds);
                })
                ->where('status', 1)
                ->groupBy('peserta_id')
                ->orderBy('count_kehadiran', 'desc')
                ->get();
        }

        return view('pages.absensi.list', $this->data);
    }

    public function absensi_form(Request $request)
    {
        if (!empty($request->input('halaqohRef'))){
            $this->data['halaqohRef'] = $request->input('halaqohRef');
        }

        $semesterActive = \App\Model\Semester::getActive();

        $halaqoh = [];
        $queryGetHalaqoh = \App\Model\View\ViewHalaqoh::where('semester_id', $semesterActive->id)->orderBy('pengajar_name');
        if (auth()->user()->isAdmin()) {
            $halaqoh = $queryGetHalaqoh->get();
        } else if (auth()->user()->isPengajar()) {
            $halaqoh = $queryGetHalaqoh->where('pengajar_id', auth()->user()->profile_id)->get();
        }
        $this->data['halaqoh'] = $halaqoh;

        return view('pages.absensi.form-absensi-kbm', $this->data);
    }

    public function save(Request $request)
    {

        $tgl             = $request->input('tgl');
        $halaqohId       = $request->input('halaqoh');

        $activity = ActivityReport::where('halaqoh_id', $halaqohId)->where('tgl', $tgl)->first();
        if ($activity) {
            return redirect("/absensi?halaqohRef=$halaqohId")->with('alert', ['message'=>"Absensi di tanggal <b>$tgl</b> sudah pernah di input !", 'type'=>'danger']);
        }

        $start_time      = $request->input('start_time');
        $note            = $request->input('note');
        $management_note = $request->input('management_note');
        $peserta         = $request->input('peserta');

        $activity = new ActivityReport;
        $activity->halaqoh_id = $halaqohId;
        $activity->tgl = $tgl;
        $activity->description = $note;
        $activity->management_note = $management_note;
        $activity->status = "NORMAL";
        $activity->start_time = "$tgl $start_time:00";

        if ($activity->save()) {

            $activityId = $activity->id;
            $anyFail = false;
            foreach ($peserta as $pesertaId => $data) 
            {
                $attendance = new Attendance;
                $attendance->activity_id = $activityId;
                $attendance->peserta_id = $pesertaId;
                $attendance->status = $data['hadir'];
                $attendance->note = $data['note'];

                if (!$attendance->save()){
                    $anyFail = true;
                }

            }

            if ($anyFail) {
                return redirect("/absensi?halaqohRef=$halaqohId")->with('alert', ['message'=>"Simpan Absensi berhasil, tapi ada beberapa peserta yang gagal di simpan", 'type'=>'danger']);
            } else {
                return redirect("/absensi?halaqohRef=$halaqohId")->with('alert', ['message'=>"Absensi tanggal <b>$tgl</b> berhasil disimpan", 'type'=>'success']);
            }

        } else {
            return redirect("/absensi/add?halaqohRef=$halaqohId")->with('alert', ['message'=>"Gagal menyimpan absensi untuk tanggal <b>$tgl</b>", 'type'=>'danger']);
        }

    }

    public function edit(Request $request, $id = null)
    {
        $halaqohId = "";
        if (!empty($request->input('halaqohRef'))){
            $halaqohId = $request->input('halaqohRef');
        }

        $activity = ActivityReport::where('id', $id)->with('attendances')->first();
        if (!$activity) {
            return redirect("/absensi?halaqohRef=$halaqohId")->with('alert', ['message'=>"Absensi tidak ditemukan", 'type'=>'danger']);
        }

        $this->data['activity'] = $activity;
        return view('pages.absensi.form-absensi-kbm-edit', $this->data);
    }

    public function update(Request $request)
    {
        $activityId = $request->input('id');
        $activity   = ActivityReport::find($activityId);

        $tgl             = $request->input('tgl');
        $halaqohId       = $activity->halaqoh_id;
        $start_time      = $request->input('start_time');
        $note            = $request->input('note');
        $management_note = $request->input('management_note');
        $peserta         = $request->input('peserta');
        $attendances     = $request->input('attendances');

        $activity->tgl              = $tgl;
        $activity->description      = $note;
        $activity->management_note  = $management_note;
        $activity->status           = "NORMAL";
        $activity->start_time       = "$tgl $start_time:00";

        if ($activity->save()) {

            $anyFail = false;
            foreach ($attendances as $attendanceId => $data) 
            {
                $attendance = Attendance::find($attendanceId);
                $attendance->status = $data['hadir'];
                $attendance->note = $data['note'];

                if (!$attendance->save()){
                    $anyFail = true;
                }

            }

            if ($anyFail) {
                return redirect("/absensi?halaqohRef=$halaqohId")->with('alert', ['message'=>"Ubah Absensi berhasil, tapi ada beberapa perubahan yang gagal di simpan", 'type'=>'danger']);
            } else {
                return redirect("/absensi?halaqohRef=$halaqohId")->with('alert', ['message'=>"Absensi tanggal <b>$tgl</b> berhasil disimpan", 'type'=>'success']);
            }

        } else {
            return redirect("/absensi/add?halaqohRef=$halaqohId")->with('alert', ['message'=>"Gagal menyimpan absensi untuk tanggal <b>$tgl</b>", 'type'=>'danger']);
        }
    }

    public function rekapKBM(Request $request)
    {
        $semesterActive = \App\Model\Semester::getActive();
        $data['kbm']    = ActivityReport::whereIn('halaqoh_id', function ($query) use ($semesterActive) {
                $query->select('id')->from('halaqoh')->where('semester_id', $semesterActive->id);
            })
            ->with('halaqoh')
            ->withCount(['attendances', 'hadir'])
            ->orderBy('tgl', 'desc')
            ->get();

        
        // TODO bikin view untuk kbm

        return view('pages.report.rekap_kbm',$data);
    }

    public function exportRekapKBM(Request $request)
    {
        $semester = Semester::getActive();

        $export = (new RekapKbmExport)->forSemester($semester->id);

        $startDate  = $request->start_date;
        $endDate    = $request->end_date;

        if (!empty($startDate) && !empty($endDate)) {
            $export->filterPeriod($startDate, $endDate);
        }

        return $export->download('rekap-kbm-'.$semester->name.'-'.date('Ymd_Hi').'.xlsx');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    public function halaqoh25()
    {
        $this->data['list'] = Cache::remember('viewPeserta.25', 60*60*24*7, function () {
            return \App\Model\View\ViewPeserta::select('nis','santri_name','pengajar_name','program_name','day','gender_santri')
                ->where('semester_id', 2)
                ->orderBy('santri_name','asc')
                ->get();
        });

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh26()
    {
        $this->data['list'] = Cache::remember('viewPeserta.26', 60*60*24*7, function () {
            return \App\Model\View\ViewPeserta::select('nis','santri_name','pengajar_name','program_name','day','gender_santri')
                ->where('semester_id', 11)
                ->orderBy('santri_name','asc')
                ->get();
        });

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh27()
    {
        $this->data['list'] = Cache::remember('viewPeserta.27', 60*60*24*7, function () {
            return \App\Model\View\ViewPeserta::select('nis','santri_name','pengajar_name','program_name','day','gender_santri')
                ->where('semester_id', 12)
                ->orderBy('santri_name','asc')
                ->get();
        });

        return view('info-halaqoh', $this->data);
    }

    public function halaqoh28()
    {
        $this->data['list'] = Cache::remember('viewPeserta.28', 60*60*24*7, function () {
            return \App\Model\View\ViewPeserta::select('nis','santri_name','pengajar_name','program_name','day','gender_santri')
                ->where('semester_id', 13)
                ->orderBy('santri_name','asc')
                ->get();
        });

        return view('info-halaqoh', $this->data);
    }

}

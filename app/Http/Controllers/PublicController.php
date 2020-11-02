<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    public function halaqoh27()
    {
        $this->data['list'] = Cache::remember('viewHalaqoh.all', 60*60*24*7, function () {
            return \App\Model\View\ViewPeserta::select('nis','santri_name','pengajar_name','program_name','day','gender')
                ->where('semester_id', 12)
                ->orderBy('santri_name','asc')
                ->get();
        });

        return view('info-halaqoh', $this->data);
    }

}

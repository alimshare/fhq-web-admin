<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $this->data['list']         = \App\Model\Temp\Temp27::get();
        
        return view('info-halaqoh', $this->data);
    }
}

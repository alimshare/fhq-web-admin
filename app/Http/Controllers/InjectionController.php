<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InjectionController extends Controller
{
	/**
	 * Public object
	 */
	$data = array();

    public function __construct($param = null)
    {
    	// $this->param = $param;
    }

    
}

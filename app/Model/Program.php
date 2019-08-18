<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Program extends Model
{
	use SoftDeletes;

    protected 	$table 		= "program";
       
    public static function getByReference($referenceId) {
    	return Program::where('reference', '=', $referenceId)->first();
    }
}

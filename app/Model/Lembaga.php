<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Lembaga extends Model
{
	
	use SoftDeletes;

    protected 	$table 		= "lembaga";
    
    public static function getByReference($referenceId) {
    	return Lembaga::where('reference', '=', $referenceId)->first();
    }

    public function getSemester(){
    	return Semester::where('lembaga_id', '=', $this->id)->get();
    }

}

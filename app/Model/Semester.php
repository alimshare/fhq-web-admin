<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Semester extends Model
{
	use SoftDeletes;

    protected 	$table 		= "semester";


    public function lembaga(){
        return $this->belongsTo('App\Model\Lembaga');
    }

    public static function getByReference($referenceId) {
    	return Semester::where('reference', '=', $referenceId)->first();
    }

    public static function getActive(){
    	return Semester::where('active', '=', 1)->get();
    }

    public function activate(){
    	/* Inactive semester active */
    	Semester::where('lembaga_id', '=', $this->lembaga_id)->where('active', '=', 1)->update(['active' => 0]);
    	/* Update current semester to active */
    	$this->active = 1;
    	return $this->save();
    }

    public function getHalaqoh(){
        return Halaqoh::where('semester_id', '=', $this->id)->get();
    }

    public function getPengajar(){
        return $this->hasManyThrough('Pengajar', 'Halaqoh', 'semester_id', 'halaqoh_id');
    }
    
}

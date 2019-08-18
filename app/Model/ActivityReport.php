<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class ActivityReport extends Model
{
    protected 	$table 		= "activity_report";

    public function getAttendance(){
    	return Attendance::whereActivityId($this->id)->get();
    }

}

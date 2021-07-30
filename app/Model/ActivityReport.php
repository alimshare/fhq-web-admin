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

    public function attendances() {
        return $this->hasMany(Attendance::class, 'activity_id');
     }

    public function halaqoh() {
        return $this->hasOne(View\ViewHalaqoh::class, 'halaqoh_id', 'halaqoh_id');
    }

    public function hadir()
    {
        return $this->attendances()->where('status', '1');
    }

}

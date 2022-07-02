<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Attendance extends Model
{
    protected 	$table 		= "attendance";    

    public function peserta() {
        return $this->hasOne(View\ViewPeserta::class, 'peserta_id', 'peserta_id');
    }
}

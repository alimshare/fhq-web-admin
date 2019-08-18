<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class PendidikanSantri extends Model
{
	use SoftDeletes;

    protected 	$table 		= "pendidikan_santri";

    public function getHalaqoh(){
    	return Halaqoh::find($this->halaqoh_id);
    }

    public function getSantri(){
    	return Santri::find($this->santri_id);
    }

}

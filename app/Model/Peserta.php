<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Peserta extends Model
{
	use SoftDeletes;

    protected 	$table 		= "peserta";

    public function getHalaqoh(){
    	return Halaqoh::find($this->halaqoh_id);
    }

    public function getSantri(){
    	return Santri::find($this->santri_id);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id', 'id');
    }

}

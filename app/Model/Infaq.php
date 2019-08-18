<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Infaq extends Model
{
    use SoftDeletes;
    
    protected 	$table 		= "infaq";

    public function getPeserta()
    {
    	return PendidikanSantri::find($this->pendidikan_id);
    }
}

<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;
use App\Model\Peserta;
use App\Model\ActivityReport;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class ViewHalaqoh extends Model
{
    protected 	$table 		= "view_halaqoh";

    public function peserta(){
        return $this->hasMany(Peserta::class, 'halaqoh_id', 'halaqoh_id');
    }

    public function kbm()
    {
        return $this->hasMany(ActivityReport::class, 'halaqoh_id', 'halaqoh_id');
    }

}

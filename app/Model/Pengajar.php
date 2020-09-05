<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class Pengajar extends Model
{
	use SoftDeletes;
	
    protected 	$table 		= "pengajar";
      
    public function user() 
    { 
        return $this->morphOne('App\User', 'profile');
    }
}

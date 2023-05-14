<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*	@since 	: Feb 2019
*/
class ViewPeserta extends Model
{
	use SoftDeletes;
    
    protected 	$table 		= "view_peserta";

}

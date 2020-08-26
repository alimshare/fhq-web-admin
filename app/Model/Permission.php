<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected 	$table 		= "permission";

    public function role() {
        return $this->belongsTo('App\Model\Role');
    }
}

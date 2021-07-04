<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected 	$table 	= "permissions";
    public $timestamps   = false;

    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions');
     }
}

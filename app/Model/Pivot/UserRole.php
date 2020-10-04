<?php

namespace App\Model\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = "users_roles"; 
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function role()
    {
        return $this->belongsTo('\App\Model\Role');
    }
}

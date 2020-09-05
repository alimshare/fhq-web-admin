<?php

namespace App\Model\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = "users_roles"; 
}

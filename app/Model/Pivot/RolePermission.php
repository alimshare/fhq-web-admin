<?php

namespace App\Model\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    protected $table = "roles_permissions"; 
}

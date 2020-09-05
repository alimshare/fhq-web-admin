<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = "roles";

    public function permissions() {
        return $this->belongsToMany(Permission::class,'roles_permissions');
     }
     
     public function users() {
        return $this->belongsToMany(User::class,'users_roles');
     }
}

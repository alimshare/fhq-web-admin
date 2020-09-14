<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Permission;
use App\Model\Pivot\RolePermission;
use App\Model\Pivot\UserRole;
use App\Model\Role;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function role(){
        return $this->belongsTo('App\Model\Role');
    }


    public function roles() {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function permissions() {
        return Permission::join('roles_permissions', 'permissions.id', 'roles_permissions.permission_id')
            ->join('users_roles', 'roles_permissions.role_id', 'users_roles.role_id')
            ->where('users_roles.user_id', $this->id);
            ;
    }

    public function hasRole($role) {
        return (bool) $this->roles()->where('slug', $role)->count();
    }

    public function hasPermission($slug)
    {
        return (bool) $this->permissions()->where('slug', $slug)->count();
    }

    public function profile()
    {
      return $this->morphTo();
    }

    public function isPengajar()
    {
      return $this->profile_type == 'App\Model\Pengajar';
    }
    public function isSantri()
    {
      return $this->profile_type == 'App\Model\Santri';
    }
    
}

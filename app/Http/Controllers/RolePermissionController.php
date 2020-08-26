<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id = "")
    {
        $data['roles'] = Role::orderBy('name','asc')->get();

        if ($id) {
            $permissions = \App\Model\Permission::orderBy('sequance','asc')->get();
            $role = Role::find($id);
            $allowedPermissions = $role->permissions()->pluck('id')->toArray();
            foreach ($permissions as $permission) {
                $allowed = false;
                if (in_array($permission->id, $allowedPermissions)) {
                    $allowed = true;
                }

                $permission->allowed = $allowed;
            }

            $data['role'] = $role;
            $data['permissions'] = $permissions;
        }

        return view('pages.role.list', $data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\User;
use App\Model\Pivot\RolePermission;
use App\Model\Pivot\UserRole;
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
        $data['userRoles'] = UserRole::with(['user','role'])->orderBy('user_id','asc')->get();

        $data['roles'] = Role::orderBy('name','asc')->get();
        $data['users'] = User::orderBy('username','asc')->with('profile')->get();

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

    public function save(Request $request)
    {
        $role_id = $request->id;

        $rolePermission = RolePermission::where('role_id', $request->id)->delete();

        if (!empty($request->permissions)) {
            $rows = [];
            foreach ($request->permissions as $k => $v) {
                $rows[] = array(
                    'role_id' => $role_id,
                    'permission_id' => $k
                );
            }
            RolePermission::insert($rows);
        }

        return redirect('role/'.$role_id);
        
    }

    public function userRoleSave(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('alert', ['type'=> 'danger', 'message'=>'User not found !']);
        }

        $roleId = $request->input('role_id');
        $role = Role::find($roleId);
        if (!$role) {
            return redirect()->back()->with('alert', ['type'=> 'danger', 'message'=>'Role not found !']);
        }

        $userRole = UserRole::where('user_id', $userId)->where('role_id', $roleId)->first();
        if ($userRole) {
            $message = "Role <b>".$role->name."</b> sudah tersedia pada <b>".$user->username."</b>.";
            return redirect()->route('role')->with('alert', ['type'=> 'success', 'message'=> $message]);
        }

        $userRole = new UserRole;
        $userRole->user_id = $userId;
        $userRole->role_id = $roleId;
        
        if ($userRole->save()) {
            $message = "Menambahkan Role <b>".$role->name."</b> kepada <b>".$user->username."</b> berhasil.";
            return redirect()->route('role')->with('alert', ['type'=> 'success', 'message'=> $message]);
        }

        $message = "Gagal menambahkan Role <b>".$role->name."</b> kepada <b>".$user->username."</b>.";
        return redirect()->back()->with('alert', ['type'=> 'danger', 'message'=>$message]);
    }

    public function userRoleRemove($userId, $roleId) 
    {
        $q = UserRole::where('user_id', $userId)->where('role_id', $roleId)->with('role','user');
        
        $userRole = $q->first();
        if (!$userRole) {
            return redirect()->To('role')->with('alert', ['type'=> 'danger', 'message'=>'Data tidak ditemukan !']);
        }

        if ($q->delete()) {
            $message = "Menghapus Role <b>".$userRole->role->name."</b> dari <b>".$userRole->user->username."</b> berhasil.";
            return redirect()->route('role')->with('alert', ['type'=> 'success', 'message'=> $message]);
        }

        $message = "Gagal menghapus Role <b>".$userRole->role->name."</b> dari <b>".$userRole->user->username."</b>.";
        return redirect()->back()->with('alert', ['type'=> 'danger', 'message'=>$message]);

    }

    public function permissions()
    {
        $data['list'] = \App\Model\Permission::orderBy('sequance','asc')->get();
        return view('pages.permission.list', $data);
    }

    public function permissionsPost(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $category = $request->input('category');
        $sequance = $request->input('sequance');

        $permission =  \App\Model\Permission::where('slug', $slug)->first();
        if ($permission) {
            return redirect()->back()->with('alert', ['type'=> 'danger', 'message'=>'Slug sudah digunakan, mohon gunakan slug lainnya karena slug harus unique.']);
        }

        $permission = new \App\Model\Permission;
        $permission->name = $name;
        $permission->slug = $slug;
        $permission->category = $category;
        $permission->sequance = $sequance;

        if ($permission->save()) {
            $message = "Menambahkan Permission <b>$slug</b> berhasil.";
            return redirect()->route('permissions')->with('alert', ['type'=> 'success', 'message'=> $message]);
        }

        $message = "Gagal Menambahkan Permission <b>$slug</b>";
        return redirect()->route('permissions')->with('alert', ['type'=> 'danger', 'message'=> $message]);
    }
}

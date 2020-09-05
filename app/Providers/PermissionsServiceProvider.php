<?php

namespace App\Providers;

use App\Model\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd(Permission::get());
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermission($permission->slug);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
        
        //Blade directives
        Blade::if('role', function ($role) {
             return auth()->check() && auth()->user()->hasRole($role);
        });

        //Blade directives
        Blade::if('allow', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
       });

    }
}

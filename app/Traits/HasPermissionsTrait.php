<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

trait HasPermissionsTrait
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function hasRole(...$roles)
    {
        ray($roles);
        ray($this->roles);
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                
                return true;
            }
        }
        return false;
    }
    public function hasPermissionTo($permission)
    {
        return $this->permissions->contains('slug', $permission);
    }
    public function isSuper(){
        if (Auth::id() == Role::where('role', 'super')->first()->id){
            return true;
        }
        return false;
    }
}

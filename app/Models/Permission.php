<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['permission'];
    public function roles(){
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}

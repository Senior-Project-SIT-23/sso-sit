<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';

    public function user_role()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }
}

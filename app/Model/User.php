<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function application_config()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
    public function user_role()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }
}

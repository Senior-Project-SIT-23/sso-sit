<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public function application_config()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
}

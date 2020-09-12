<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    public function application_config()
    {
        return $this->hasOne(ApplicationConfig::class, 'app_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pages()
    {
        return $this->hasOne(Page::class, 'app_id');
    }
}

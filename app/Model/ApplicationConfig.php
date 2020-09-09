<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationConfig extends Model
{
    protected $table = 'application_config';

    public function applications()
    {
        return $this->belongsTo(Application::class, 'app_id');
    }
}

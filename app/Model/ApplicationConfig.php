<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationConfig extends Model
{
    protected $table = 'application_config';
    protected $primaryKey = 'manage_id';

    public function applications()
    {
        return $this->belongsTo(Application::class, 'app_id');
    }
}

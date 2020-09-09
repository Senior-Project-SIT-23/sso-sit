<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    public function applications()
    {
        return $this->belongsTo(Application::class, 'app_id');
    }
}

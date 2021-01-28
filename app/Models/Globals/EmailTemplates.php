<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{
    protected $fillable = ['user_id','name','slug','body'];
}

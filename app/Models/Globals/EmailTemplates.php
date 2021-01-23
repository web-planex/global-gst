<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{
    protected $fillable = ['name','slug','body','status'];
}

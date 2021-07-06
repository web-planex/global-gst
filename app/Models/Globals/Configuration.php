<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['user_id','company_id','from_email','from_name','smtp_host','smtp_username','smtp_password',
        'smtp_port','smtp_security'];
}

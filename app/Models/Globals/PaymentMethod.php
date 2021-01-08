<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['user_id','method_name'];
}

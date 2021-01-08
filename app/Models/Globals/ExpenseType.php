<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = ['user_id','company_id','name','description'];
}

<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    protected $fillable = ['tax_name','rate','status'];
}

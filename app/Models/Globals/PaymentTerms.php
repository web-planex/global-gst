<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class PaymentTerms extends Model
{
    protected $fillable = ['user_id','company_id','terms_name','terms_days'];
}

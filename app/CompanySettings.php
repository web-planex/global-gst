<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    protected $fillable = ['user_id','company_name','company_logo','pan_no','gstin','company_email','company_phone',
        'website','street','city','state','pincode','country'];
}

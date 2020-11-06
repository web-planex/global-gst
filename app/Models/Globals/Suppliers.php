<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $fillable = ['user_id','first_name','last_name','email','company','phone','mobile','display_name','website',
        'street','city','state','pincode','country','billing_rate','pan_no','account_no','apply_tds_for_supplier',
        'gstin','gst_registration_type_id'];
}

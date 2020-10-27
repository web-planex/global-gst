<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = ['first_name','last_name','email','company','phone','mobile','display_name','website',
        'gstin','gst_registration_type_id','billing_street','billing_city','billing_state','billing_pincode',
        'billing_country','shipping_street','shipping_city','shipping_state','shipping_pincode',
        'shipping_country'];
}

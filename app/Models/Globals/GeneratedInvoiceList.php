<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class GeneratedInvoiceList extends Model
{
    protected $fillable =['user_id','company_id','invoice_id','invoice'];
}

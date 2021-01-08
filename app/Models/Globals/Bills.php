<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'tax_type',
        'payee_id',
        'bill_date',
        'payment_method',
        'bill_no',
        'due_date',
        'payment_term_id',
        'discount_level',
        'amount_before_tax',
        'tax_amount',
        'total',
        'discount',
        'discount_type',
        'memo',
        'files',
        'status'
    ];
}

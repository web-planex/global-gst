<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class BillItems extends Model
{
    protected $fillable = [
        'bill_id',
        'product_id',
        'tax_id',
        'hsn_code',
        'quantity',
        'rate',
        'amount'
    ];
}

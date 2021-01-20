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
        'amount',
        'discount',
        'discount_type'
    ];
    public function Product(){
        return $this->belongsTo('App\Models\Globals\Product','product_id');
    }
}

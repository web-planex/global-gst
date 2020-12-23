<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $fillable = ['invoice_id','product_id','hsn_code','quantity','rate','amount','tax_id'];

    public function Product(){
        return $this->belongsTo('App\Models\Globals\Product','product_id');
    }
}

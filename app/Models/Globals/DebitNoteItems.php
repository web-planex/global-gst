<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class DebitNoteItems extends Model
{
    protected $fillable = [
        'debit_note_id',
        'product_id',
        'tax_id',
        'hsn_code',
        'quantity',
        'rate',
        'amount',
        'discount',
        'discount_type',
    ];

    public function Product(){
        return $this->belongsTo('App\Models\Globals\Product','product_id');
    }
}

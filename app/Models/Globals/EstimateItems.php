<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class EstimateItems extends Model
{
    protected $fillable = ['estimate_id','product_id','hsn_code','quantity','rate','amount','tax_id'];

    public function Product(){
        return $this->belongsTo('App\Models\Globals\Product','product_id');
    }
}

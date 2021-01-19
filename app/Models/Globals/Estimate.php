<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = ['user_id','company_id','estimate_number','tax_type','customer_id',
        'estimate_date','expiry_date','amount_before_tax','tax_amount','discount_level','discount','discount_type','total',
        'files','shipping_charge','shipping_charge_amount'];

    public function Payee(){
        return $this->belongsTo('App\Models\Globals\Payees','customer_id');
    }

    public function EstimateItems(){
        return $this->hasMany('App\Models\Globals\EstimateItems','estimate_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($data) {
            $data->EstimateItems()->delete();
        });
    }
}

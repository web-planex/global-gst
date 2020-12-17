<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id','company_id','tax_type','customer_id','customer_email','invoice_date',
        'due_date','place_of_supply','amount_before_tax','tax_amount','discount','discount_type',
        'total','files'];

    public function Payee(){
        return $this->belongsTo('App\Models\Globals\Payees','customer_id');
    }

    public function InvoiceItems(){
        return $this->hasMany('App\Models\Globals\InvoiceItems','invoice_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($comment) {
            $comment->InvoiceItems()->delete();
        });
    }
}

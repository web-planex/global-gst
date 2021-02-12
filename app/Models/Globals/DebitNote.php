<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'debit_note_number',
        'ref_invoice_no',
        'ref_invoice_date',
        'tax_type',
        'customer_id',
        'debite_note_date',
        'due_date',
        'payment_term_id',
        'amount_before_tax',
        'tax_amount',
        'discount_level',
        'discount',
        'discount_type',
        'total',
        'files',
        'status',
        'shipping_charge',
        'shipping_charge_amount',
        'notes',
    ];
    
    public function DebitNoteItems(){
        return $this->hasMany('App\Models\Globals\DebitNoteItems','debit_note_id');
    }

    public function Payee(){
        return $this->belongsTo('App\Models\Globals\Payees','customer_id');
    }
    
    public function Invoice(){
        return $this->belongsTo('App\Models\Globals\Invoice','ref_invoice_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($debit_note) {
            $debit_note->DebitNoteItems()->delete();
        });
    }
}

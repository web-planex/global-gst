<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id','company_id','invoice_number','credit_note_number','tax_type','customer_id','invoice_date',
        'due_date','amount_before_tax','tax_amount','discount','discount_type',
        'total','files','payment_method','status'];

    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_REFUNDED = 3;
    const STATUS_VOIDED= 4;

    public static $invoice_status = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_PAID => 'Paid',
        self::STATUS_REFUNDED => 'Refunded',
        self::STATUS_VOIDED => 'Voided',
    ];

    const PAYMENT_METHOD_CASH = 1;
    const PAYMENT_METHOD_CHEQUE = 2;
    const PAYMENT_METHOD_CREDIT_CARD = 3;

    public static $payment_method = [
        self::PAYMENT_METHOD_CASH => 'Cash',
        self::PAYMENT_METHOD_CHEQUE => 'Cheque',
        self::PAYMENT_METHOD_CREDIT_CARD => 'Credit Card',
    ];

    public function Payee(){
        return $this->belongsTo('App\Models\Globals\Payees','customer_id');
    }

    public function InvoiceItems(){
        return $this->hasMany('App\Models\Globals\InvoiceItems','invoice_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($data) {
            $data->InvoiceItems()->delete();
        });
    }
}

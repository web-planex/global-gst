<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id','company_id','invoice_number','order_number','reference_number',
        'credit_note_number','tax_type','is_cess','customer_id','invoice_date','due_date','void_date',
        'payment_date','amount_before_tax','tax_amount','discount','discount_level','discount_type',
        'total','files','payment_method','payment_terms','status','shipping_charge',
        'shipping_charge_amount','notes'];

    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
//    const STATUS_VOIDED= 3;
//    const STATUS_REFUNDED = 4;


    public static $invoice_status = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_PAID => 'Paid',
//        self::STATUS_VOIDED => 'Voided',
//        self::STATUS_REFUNDED => 'Refunded',

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
        return $this->hasMany('App\Models\Globals\InvoiceItems','invoice_id','id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($data) {
            $data->InvoiceItems()->delete();
        });
    }
}

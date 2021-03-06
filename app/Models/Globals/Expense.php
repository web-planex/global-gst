<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'tax_type',
        'is_cess',
        'payee_id',
        'expense_date',
        'payment_method',
        'ref_no',
        'expense_category_id',
        'amount_before_tax',
        'tax_amount',
        'total',
        'memo',
        'files',
        'status'
    ];

    const PAYMENT_METHOD_CASH = 1;
    const PAYMENT_METHOD_CHEQUE = 2;
    const PAYMENT_METHOD_CREDIT_CARD = 3;

    public static $payment_method = [
        self::PAYMENT_METHOD_CASH => 'Cash',
        self::PAYMENT_METHOD_CHEQUE => 'Cheque',
        self::PAYMENT_METHOD_CREDIT_CARD => 'Credit Card',
    ];

    const USER_1 = 1;
    const USER_2 = 2;
    const USER_3 = 3;

    public static $user_type = [
        self::USER_1 => 'Suppliers',
        self::USER_2 => 'Employees',
        self::USER_3 => 'Customers',
    ];
    
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_VOIDED= 3;
    
    public static $expense_status = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_PAID => 'Paid',
        self::STATUS_VOIDED => 'Voided'
    ];

    public function ExpenseItems(){
        return $this->hasMany('App\Models\Globals\ExpenseItems','expense_id');
    }

    public function Payee(){
        return $this->belongsTo('App\Models\Globals\Payees','payee_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($comment) {
            $comment->ExpenseItems()->delete();
        });
    }

    public function PaymentMethod(){
        return $this->belongsTo('App\Models\Globals\PaymentMethod','payment_method');
    }
}

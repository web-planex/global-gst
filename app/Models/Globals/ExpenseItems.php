<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class ExpenseItems extends Model
{
    protected $fillable = [
        'expense_id',
        'tax_id',
        'product',
        'hsn_code',
        'quantity',
        'rate',
        'amount'
    ];

    const PAYMENT_METHOD_CASH = 1;
    const PAYMENT_METHOD_CHEQUE = 2;
    const PAYMENT_METHOD_CREDIT_CARD = 3;

    public static $payment_method = [
        self::PAYMENT_METHOD_CASH => 'Cash',
        self::PAYMENT_METHOD_CHEQUE => 'Cheque',
        self::PAYMENT_METHOD_CREDIT_CARD => 'Credit Card',
    ];
}

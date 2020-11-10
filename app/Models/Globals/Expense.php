<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'tax_id',
        'tax_type',
        'payee_id',
        'payment_account_id',
        'payment_date',
        'payment_method',
        'ref_no',
        'expense_category_id',
        'amount_before_tax',
        'tax_amount',
        'total'
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

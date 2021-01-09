<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'tax_type',
        'payee_id',
        'bill_date',
        'payment_method',
        'bill_no',
        'due_date',
        'payment_term_id',
        'discount_level',
        'amount_before_tax',
        'tax_amount',
        'total',
        'discount',
        'discount_type',
        'memo',
        'files',
        'status'
    ];
    
    const STATUS_OPEN = 1;
    const STATUS_PAID = 2;
    const STATUS_VOID= 3;
    const STATUS_OVERDUE= 4;
    
    public static $bill_status = [
        self::STATUS_OPEN => 'Open',
        self::STATUS_PAID => 'Paid',
        self::STATUS_VOID => 'Void',
        self::STATUS_OVERDUE => 'Overdue'
    ];
    
    public function BillItems(){
        return $this->hasMany('App\Models\Globals\BillItems','bill_id');
    }

    public function Payee(){
        return $this->belongsTo('App\Models\Globals\Payees','payee_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($bill) {
            $bill->BillItems()->delete();
        });
    }
}

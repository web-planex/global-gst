<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['user_id','payee_id','payment_account_id','payment_date','payment_method','ref_no','expense_category_id','item_id'];
}

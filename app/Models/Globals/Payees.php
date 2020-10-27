<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Payees extends Model
{
    protected $fillable = ['name','type','type_id'];

    const TYPE_SUPPLIERS = 1;
    const TYPE_EMPLOYEES = 2;
    const TYPE_CUSTOMERS = 3;

    public static $type = [
        self::TYPE_SUPPLIERS => 'Suppliers',
        self::TYPE_EMPLOYEES => 'Employees',
        self::TYPE_CUSTOMERS => 'Customers',
    ];
}

<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Payees extends Model
{
    protected $fillable = ['name','type','type_id'];

    const TYPE_SUPPLIERS = 'suppliers';
    const TYPE_EMPLOYEES = 'employees';
    const TYPE_CUSTOMERS = 'customers';

    public static $type = [
        self::TYPE_SUPPLIERS => 'Suppliers',
        self::TYPE_EMPLOYEES => 'Employees',
        self::TYPE_CUSTOMERS => 'Customers',
    ];

    const GST_REGULAR = 1;
    const GST_COMPOSITION = 2;
    const GST_UNREGISTERED = 3;
    const GST_OVERSEAS = 4;
    const GST_SEZ = 5;

    public static $get_type = [
        self::GST_REGULAR => 'GST registered Regular',
        self::GST_COMPOSITION => 'GST registered Composition',
        self::GST_UNREGISTERED => 'GST unregistered',
        self::GST_OVERSEAS => 'Overseas',
        self::GST_SEZ => 'SEZ',
    ];
}

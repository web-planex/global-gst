<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Payees extends Model
{
    protected $fillable = ['user_id','name','type','type_id'];

    const TYPE_SUPPLIERS = 1;
    const TYPE_EMPLOYEES = 2;
    const TYPE_CUSTOMERS = 3;

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

    public function Suppliers(){
        return $this->belongsTo('App\Models\Globals\Suppliers','type_id');
    }

    public function Employees(){
        return $this->belongsTo('App\Models\Globals\Employees','type_id');
    }

    public function Customers(){
        return $this->belongsTo('App\Models\Globals\Customers','type_id');
    }
}

<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id','company_id','title','description','hsn_code','sku','unit','price','sale_price','status'];
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    const UNIT_KG = 'KG';
    const UNIT_G = 'GRAM';
    const UNIT_ML = 'ML';
    const UNIT_L = 'L';
    const UNIT_PIECE = 'PIECE';
    const UNIT_QT = 'QT';
    const UNIT_BOX = 'BOX';
    const UNIT_CM = 'CM';
    const UNIT_DZ = 'DZ';
    const UNIT_FT = 'FT';
    const UNIT_IN = 'IN';
    const UNIT_KM = 'KM';
    const UNIT_LB = 'LB';
    const UNIT_MG = 'MG';
    const UNIT_M = 'M';

    public static $unit = [
        self::UNIT_KG => 'KG',
        self::UNIT_G => 'GRAM',
        self::UNIT_ML => 'ML',
        self::UNIT_L => 'L',
        self::UNIT_PIECE => 'PIECE',
        self::UNIT_QT => 'QT',
        self::UNIT_BOX => 'BOX',
        self::UNIT_CM => 'CM',
        self::UNIT_DZ => 'DZ',
        self::UNIT_FT => 'FT',
        self::UNIT_IN => 'IN',
        self::UNIT_KM => 'KM',
        self::UNIT_LB => 'LB',
        self::UNIT_MG => 'MG',
        self::UNIT_M => 'M',
    ];

    public function User(){
        return $this->belongsTo('App\User','user_id')->select('id','name');
    }

    public function Company(){
        return $this->belongsTo('App\Models\Globals\CompanySettings','company_id')->select('id','company_name');
    }
}

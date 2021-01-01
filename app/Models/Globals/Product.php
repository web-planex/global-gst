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

    public static $unit = [
        self::UNIT_KG => 'KG',
        self::UNIT_G => 'GRAM',
        self::UNIT_ML => 'ML',
        self::UNIT_L => 'L',
        self::UNIT_PIECE => 'PIECE',
        self::UNIT_QT => 'QT',
    ];
}

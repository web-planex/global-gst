<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['user_id','company_id','title','description','hsn_code','sku','price','status'];
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];
}

<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = ['user_id','company_id','first_name','last_name','email','display_name','phone','mobile','street','city',
        'state','pincode','country','gender','hire_date','released','date_of_birth','notes'];

    const GENDER_MALE = '1';
    const GENDER_FEMALE = '0';

    public static $gender = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
    ];
}

<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
     protected $fillable = ['user_id','company_name','company_logo','pan_no','gstin','company_email','company_phone',
        'website','street','city','state','pincode','country'];

    public function Expense(){
        return $this->hasMany('App\Models\Globals\Expense','company_id');
    }

    public function Payee(){
        return $this->hasMany('App\Models\Globals\Payees','company_id');
    }

    public function Suppliers(){
        return $this->hasMany('App\Models\Globals\Suppliers','company_id');
    }

    public function Employee(){
        return $this->hasMany('App\Models\Globals\Employees','company_id');
    }

    public function Customers(){
        return $this->hasMany('App\Models\Globals\Customers','company_id');
    }

    public function PaymentAccount(){
        return $this->hasMany('App\Models\Globals\PaymentAccount','company_id');
    }

    public function InvoiceSetting(){
        return $this->hasMany('App\Models\Globals\InvoiceSetting','company_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($post) {
            $post->Expense()->delete();
            $post->Payee()->delete();
            $post->Suppliers()->delete();
            $post->Employee()->delete();
            $post->Customers()->delete();
            $post->PaymentAccount()->delete();
            $post->InvoiceSetting()->delete();
        });
    }
}

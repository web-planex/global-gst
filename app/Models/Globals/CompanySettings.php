<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
     protected $fillable = ['user_id','company_name','company_logo','signature_image','pan_no','gstin',
         'company_email','company_phone', 'website','street','city','state','pincode','country', 'iec_code',
         'cin_number','fssai_lic_number','invoice_prefix','invoice_number','credit_note_prefix',
         'credit_note_number','product_price_gst','shipping_price_gst','shipping_gst','igst_on_export_order',
         'terms_and_condition','email_notification','email_notification_for_site_admin','job_id'];

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

    public function Invoice(){
        return $this->hasMany('App\Models\Globals\Invoice','company_id');
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
            $post->Invoice()->delete();
            $post->InvoiceSetting()->delete();
        });
    }
}

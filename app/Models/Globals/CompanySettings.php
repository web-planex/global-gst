<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    protected $fillable = ['user_id','color','pdf_template','company_name','company_logo','signature_image','pan_no','gstin',
         'company_email','company_phone', 'website','street','city','state','pincode','country', 'iec_code',
         'cin_number','fssai_lic_number','invoice_prefix','invoice_number','credit_note_prefix',
         'credit_note_number','estimate_prefix','estimate_number','product_price_gst',
         'shipping_price_gst','shipping_gst','igst_on_export_order','terms_and_condition',
         'email_notification','email_notification_for_site_admin','job_id'];

    const COLOR_1 = '06a2df';
    const COLOR_2 = 'd75b5c';
    const COLOR_3 = '042F62';
    const COLOR_4 = '917795';
    const COLOR_5 = '00bbbd';
    const COLOR_6 = 'c8758c';

    public static $invoice_color = [
        self::COLOR_1 => 'Blue',
        self::COLOR_2 => 'Italiano Rose',
        self::COLOR_3 => 'Blue Lagoon',
        self::COLOR_4 => 'Wilde Orchid',
        self::COLOR_5 => 'Teal',
        self::COLOR_6 => 'Wild Pink',
    ];

    const TEMPLATE_1 = '1';
    const TEMPLATE_2 = '2';
    const TEMPLATE_3 = '3';
    const TEMPLATE_4 = '4';
    const TEMPLATE_5 = '5';

    public static $template = [
        self::TEMPLATE_1 => 'Professional',
        self::TEMPLATE_2 => 'Minimal',
        self::TEMPLATE_3 => 'Modern',
        self::TEMPLATE_4 => 'Classic',
        self::TEMPLATE_5 => 'Standard',
    ];

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

//    public function PaymentAccount(){
//        return $this->hasMany('App\Models\Globals\PaymentAccount','company_id');
//    }

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
//            $post->PaymentAccount()->delete();
            $post->Invoice()->delete();
            $post->InvoiceSetting()->delete();
        });
    }
}

<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $fillable = ['user_id','logo_image','signature_image','store_name','brand_name','store_address','contact_person',
        'store_phone','store_email','gst_number','iec_code','cin_number','pan_number','fssai_lic_number','invoice_prefix',
        'invoice_number','credit_note_prefix','credit_note_number','product_price_gst','shipping_price_gst','shipping_gst',
        'igst_on_export_order','terms_and_condition','email_notification','email_notification_for_site_admin'];


    const AUTOMATICALLY_ORDER_CREATED = 1;
    const AUTOMATICALLY_ORDER_PAID = 2;
    const AUTOMATICALLY_ORDER_FULFILLED = 3;
    const AUTOMATICALLY_DONT_SEND = 4;


    public static $email_notification = [
        self::AUTOMATICALLY_ORDER_CREATED => 'Automatically send invoices when the orders are Created.',
        self::AUTOMATICALLY_ORDER_PAID => 'Automatically send invoices when the orders are Paid.',
        self::AUTOMATICALLY_ORDER_FULFILLED => 'Automatically send invoices when the orders are Fulfilled.',
        self::AUTOMATICALLY_DONT_SEND => 'Do not send any Automatic invoice.',
    ];
}

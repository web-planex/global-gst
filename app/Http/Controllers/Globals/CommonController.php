<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function VoidAmount($fields_key_array, $main_invoice, $subarray, $company, $pay_user, $product, $new_amount_before_tax, $main_tax, $tax1, $sgst1, $cgst1, $igst1, $cess1, $payment_method){
        $data = array_merge(array_flip($fields_key_array), array_filter(array(
            'invoice_number' => $main_invoice['invoice_number'],
            'credit_note_number' => $main_invoice['credit_note_number'],
            'invoice_date' => date('d-m-Y', strtotime($main_invoice['invoice_date'])),
            'gstin' => $company['gstin'],
            'customer_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
            'customer_phone' => $pay_user['mobile'],
            'customer_address' => $pay_user['billing_street'].', '.$pay_user['billing_city'].'-'.$pay_user['billing_pincode'].', '.$pay_user['state'].', '.$pay_user['billing_country'],
            'customer_gstin' => $pay_user['gstin'],
            'product' => $product['title'],
            'hsn_code' => $subarray['hsn_code'],
            'quantity' => $subarray['quantity'],
            'rate' => $subarray['rate'],
            'tax_type' => $main_invoice['tax_type']==1 ? 'Exclusive' : ($main_invoice['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
            'amount_before_tax' => $main_invoice['tax_type']==2 ? number_format($new_amount_before_tax,2) : number_format($subarray['amount'],2),
            'amount_after_tax' => $main_invoice['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
            'sgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
            'cgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
            'igst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax1['tax_name']) == 'igst'?$tax1['rate']:0,
            'cess_%' => in_array($main_invoice['tax_type'], [1,2]) && $tax1['is_cess'] == 1 ? $tax1['cess']:0,
            'sgst' => number_format($sgst1,2),
            'cgst' => number_format($cgst1,2),
            'igst' => number_format($igst1,2),
            'cess' => number_format($cess1,2),
            'total_tax' => number_format($main_tax,2),
            'discount_level' => $main_invoice['discount_level']==0 ? 'Transaction Level' : 'Item Level',
            'discount_type' => $main_invoice['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_invoice['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
            'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
            'payment_method' => $payment_method['method_name'],
            'status' => $main_invoice['status']==1?'Pending':($main_invoice['status']==2?'Paid':'Voided'),
            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
        ),
        function ($key) use ($fields_key_array) {
            return in_array($key, $fields_key_array);
        }, ARRAY_FILTER_USE_KEY));
    }
}

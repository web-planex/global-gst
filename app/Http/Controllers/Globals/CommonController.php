<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Bills;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Estimate;
use App\Models\Globals\Expense;
use App\Models\Globals\Invoice;
use App\Models\Globals\Payees;
use App\Models\Globals\States;
use App\Models\Globals\Suppliers;
use App\Models\Globals\Taxes;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function AllTaxes($type, $type_id, $tax_id, $amount){
        $cgst = 0;
        $sgst = 0;
        $igst = 0;
        $cess = 0;
        if($type == 1){
            $main_type = Expense::where('id',$type_id)->first();
        }elseif ($type == 2){
            $main_type = Invoice::where('id',$type_id)->first();
        }elseif ($type == 3){
            $main_type = Estimate::where('id',$type_id)->first();
        }else{
            $main_type = Bills::where('id',$type_id)->first();
        }

        $tax = Taxes::where('id',$tax_id)->first();
        if(!empty($tax)){
            $amount_tax = $amount * $tax['rate'] / (100 + $tax['rate']);
            if(strtolower($tax['tax_name']) == 'gst'){
                $total_tax = $tax['rate'] / 2;
                $main_tax = $main_type['tax_type'] == 2 ? $amount_tax / 2 : ($main_type['tax_type']==1 ? $amount * $total_tax / 100 : 0) ;
                $cgst = $main_tax;
                $sgst = $main_tax;
            }

            if(strtolower($tax['tax_name']) == 'igst'){
                $main_igst = $main_type['tax_type'] == 2 ? $amount_tax : ($main_type['tax_type']==1 ? $amount * $tax['rate'] / 100 : 0) ;
                $igst = $main_igst;
            }

            if($tax['is_cess'] == 1){
                $amount_cess = $amount * $tax['cess'] / (100 + $tax['cess']);
                $main_cess = $main_type['tax_type'] == 2 ? $amount_cess  : ($main_type['tax_type']==1 ? $amount * $tax['cess'] / 100 : 0) ;
                $cess = $main_cess;
            }
        }
        return $all_taxes = [$cgst, $sgst, $igst, $cess];
    }

    public function Headers($type){
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$type."_report.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        return $headers;
    }

    public function PayUser($pay_id){
        $payee = Payees::where('id',$pay_id)->first();
        if(!empty($payee)){
            if($payee['type']==1){
                $pay_user = Suppliers::where('id',$payee['type_id'])->first();
            }elseif ($payee['type']==2){
                $pay_user = Employees::where('id',$payee['type_id'])->first();
            }else{
                $pay_user = Customers::where('id',$payee['type_id'])->first();
                $pay_user['street'] = $pay_user['billing_street'];
                $pay_user['city'] = $pay_user['billing_city'];
                $pay_user['pincode'] = $pay_user['billing_pincode'];
                $pay_user['country'] = $pay_user['billing_country'];
                $pay_user['state'] = $pay_user['billing_state'];
            }
            $state = States::where('id',$pay_user['state'])->first();
            $pay_user['state'] = $state['state_name'];
            $pay_user['pay_type'] = $payee['type'];
        }
        return $pay_user;
    }

    public function TaxCount($tax_id,$amount,$tax_type){
        $sgst1 = 0;
        $cgst1 = 0;
        $igst1 = 0;
        $cess1 = 0;

        $tax1 = Taxes::where('id',$tax_id)->first();

        $amount_before_tax = $amount * $tax1['rate'] / (100 + $tax1['rate']);
        $new_amount_before_tax = $amount - $amount_before_tax;

        if(!empty($tax1)){
            if(strtolower($tax1['tax_name']) == 'gst'){
                $total_tax1 = $tax1['rate'] / 2;
                $cgst1 = $tax_type==2 ? $amount_before_tax / 2 : ($tax_type==1 ? $amount * $total_tax1 / 100 : 0);
                $sgst1 = $tax_type==2 ? $amount_before_tax / 2 : ($tax_type==1 ? $amount * $total_tax1 / 100 : 0);
            }
            if(strtolower($tax1['tax_name']) == 'igst'){
                $igst1 = $tax_type==2 ? $amount_before_tax : ($tax_type==1 ? $amount * $tax1['rate'] / 100 : 0);
            }
            if($tax1['is_cess'] == 1){
                $cess1 = $tax_type==2 ? $amount * $tax1['cess'] / (100 + $tax1['cess']) : ($tax_type == 1 ?$amount * $tax1['cess'] / 100 : 0);
            }
        }
        return $all_taxes = [
            $sgst1, //0
            $cgst1, //1
            $igst1, //2
            $cess1, //3
            $new_amount_before_tax, //4
            $tax1, //5
        ];
    }
}

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
    
    public function convert_digit_to_words($no){
        //creating array of word for each digit
        $words = array('0'=> 'Zero' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninety','100' => 'hundred','1000' => 'thousand','100000' => 'lac','10000000' => 'crore');

        //for decimal number taking decimal part
        $cash=(int)$no; //take number wihout decimal
        $decpart = $no - $cash; //get decimal part of number
        $decpart=sprintf("%01.2f",$decpart); //take only two digit after decimal
        $decpart1=substr($decpart,2,1); //take first digit after decimal
        $decpart2=substr($decpart,3,1); //take second digit after decimal
        $decimalstr='';
        //if given no. is decimal than preparing string for decimal digit's word
        if($decpart>0){
            $decimalstr.="point ".$words[$decpart1]." ".$words[$decpart2];
        }

        if($no == 0)
            return ' ';
        else {
            $novalue='';
            $highno=$no;
            $remainno=0;
            $value=100;
            $value1=1000;
            while($no>=100) {
                if(($value <= $no) &&($no < $value1)) {
                    $novalue=$words["$value"];
                    $highno = (int)($no/$value);
                    $remainno = $no % $value;
                    break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }
            if(array_key_exists("$highno",$words)) //check if $high value is in $words array
            return $words["$highno"]." ".$novalue." ".$this->convert_digit_to_words($remainno).$decimalstr; //recursion
            else {
                $unit=$highno%10;
                $ten =(int)($highno/10)*10;
                return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->convert_digit_to_words($remainno).$decimalstr; //recursion
            }
        }
    }
    
    public function globalPdfOption() {
         $global_options = [
            'binary' => 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf',
//            'binary' => '/usr/bin/wkhtmltopdf',
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
            'header-spacing'=> 5,
            'footer-html' => view('globals.pdf-footer')->render()
        ]; 
        return $global_options ;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Globals\Bills;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\EmailTemplates;
use App\Models\Globals\Estimate;
use App\Models\Globals\Expense;
use App\Models\Globals\Invoice;
use App\Models\Globals\Taxes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $pagination = 20;
    
    public function image($photo, $path){
        $root = base_path() . '/public/upload/' . $path;
        $name = str_random(20) . "." . $photo->getClientOriginalExtension();
        $mimetype = $photo->getMimeType();
        $explode = explode("/", $mimetype);
        $type = $explode[0];
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root, $name);
        return $path = "upload/" . $path . "/" . $name;
    }

    public function allFiles($photo, $path){
        $root = base_path() . '/public/upload/' . $path;
        $name = $photo->getClientOriginalName();
        $mimetype = $photo->getMimeType();
        $explode = explode("/", $mimetype);
        $type = $explode[0];
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root, $name);
        return $path = "upload/" . $path . "/" . $name;
    }

    public function Company(){
        return Session::get('company');
    }

    public static function AuthUser(){
        return $user_detail = Auth::user();
    }

    public static function AllCompanies(){
        return $all_companies =CompanySettings::where('user_id',Auth::user()->id)->select('company_name','id')->get();
    }

    public static function SetCompany(){
        return $set_company = Session::get('company');
    }

    public static function AllEmailTemplates() {
        return EmailTemplates::where('user_id',Auth::user()->id)->where('status',1)->get();
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
    
    public function globalPdfOption($data) {
         $global_options = [
            'binary' => 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf',
//            'binary' => '/usr/bin/wkhtmltopdf',
//            'header-html' => $header_html,
//            'footer-html' => $footer_html,
            'footer-html' => view('globals.pdf-footer',$data)
        ]; 
        return $global_options ;
    }

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
}

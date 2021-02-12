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

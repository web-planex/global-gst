<?php

namespace App\Http\Controllers;

use App\CompanySettings;
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
    protected $pagination = 15;
    public function image($photo, $path)
    {
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

    public function Company(){
        return Session::get('company');
    }

    public static function AuthUser(){
        return $user_detail = Auth::user();
    }

    public static function AllCompanies(){
        return $all_companies = CompanySettings::where('user_id',Auth::user()->id)->select('company_name','id')->get();
    }

    public static function SetCompany(){
        return $set_company = Session::get('company');
    }
}

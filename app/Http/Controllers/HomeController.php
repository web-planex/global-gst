<?php

namespace App\Http\Controllers;

use App\Models\Globals\CompanySettings;
use App\Models\Globals\Expense;
use App\Models\Globals\Invoice;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Bills;
use App\Models\Globals\Estimate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(){
        $data['menu'] = 'Home';
        return view('website.index',$data);
    }

    public function terms_condition(){
        $data['menu'] = 'Terms_Conditions';
        return view('website.terms',$data);
    }

    public function privacy_policy(){
        $data['menu'] = 'Privacy_Policy';
        return view('website.privacy_policy',$data);
    }
}

<?php

namespace App\Http\Controllers;

use App\CompanySettings;
use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['menu'] = 'Dashboard';
        $data['total_expense'] = Expense::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->count();
        $data['total_payee'] = Payees::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->count();
        $data['total_payment_account'] = PaymentAccount::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->count();
        $data['total_companies'] = CompanySettings::where('user_id',Auth::user()->id)->count();
        $data['user_id'] = Auth::user()->id;
        $session = Session::get('company');
        if(empty($session)){
            $company = CompanySettings::where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
            if(!empty($company)){
                $data['session_company'] = session(['company'=>$company['id']]);
            }
        }
        return view('dashboard',$data);
    }
}

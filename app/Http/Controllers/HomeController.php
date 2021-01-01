<?php

namespace App\Http\Controllers;

use App\Models\Globals\CompanySettings;
use App\Models\Globals\Expense;
use App\Models\Globals\Invoice;
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
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $session = Session::get('company');
        if(empty($session)){
            $company = CompanySettings::where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
            if(!empty($company)){
                 session(['company'=>$company['id']]);
                 $data['session_company'] = Session::get('company');
            }else{
                $data['session_company'] = 0;
            }
        }else{
            $data['session_company'] = $this->Company();
        }
        $data['menu'] = 'Dashboard';
        $data['total_product'] = \App\Models\Globals\Product::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_expense'] = Expense::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_sales'] = Invoice::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_credit_note'] = Invoice::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->whereIn('status',[3,4])->count();
        $data['total_payee'] = Payees::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_payment_account'] = PaymentAccount::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_companies'] =CompanySettings::where('user_id',Auth::user()->id)->count();
        $data['user_id'] = Auth::user()->id;
        return view('dashboard',$data);
    }
}

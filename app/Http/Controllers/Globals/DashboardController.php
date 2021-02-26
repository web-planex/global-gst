<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Mail\Globals\SignUpMail;
use App\Models\Globals\Bills;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Estimate;
use App\Models\Globals\Expense;
use App\Models\Globals\Invoice;
use App\Models\Globals\DebitNote;
use App\Models\Globals\Payees;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('UserAccessRight');
    }

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
        $data['total_bills'] = Bills::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_estimates'] = Estimate::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_sales'] = Invoice::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_credit_note'] = Invoice::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->whereIn('status',[3,4])->count();
        $data['total_payee'] = Payees::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
//        $data['total_payment_account'] = PaymentAccount::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_debit_notes'] = DebitNote::where('user_id',Auth::user()->id)->where('company_id',$data['session_company'] )->count();
        $data['total_companies'] =CompanySettings::where('user_id',Auth::user()->id)->count();
        $data['user_id'] = Auth::user()->id;
        return view('dashboard',$data);
    }

    public function send_mail(){
        $user = Auth::user();
        $company_logo = url('assets/images/logo_2.png');
        $customer_name = ucwords($user['name']);
        $data = ['company_logo' => $company_logo,'customer_name' => $customer_name];

        $to = $user['email'];
        $from = env('MAIL_FROM_ADDRESS');
        $subject = "Welcome to GST Invoices by WebPlanex";
        $message = view('globals.emails.sign-up',$data);

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";
        $headers .= 'Reply-To: ' .$from . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        \mail($to, $subject, $message, $headers);
        return 'Done';
    }
}

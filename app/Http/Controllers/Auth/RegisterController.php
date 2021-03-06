<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Globals\CommonController;
use App\Http\Controllers\Globals\DKIMConfigurationController;
use App\Mail\Globals\EmailVerification;
use App\Mail\Globals\SignUpMail;
use App\Mail\Globals\VerifyEmail;
use App\Models\Globals\CompanySettings;
use App\Http\Controllers\Controller;
use App\Models\Globals\PaymentTerms;
use App\Models\Globals\ExpenseType;
use App\Models\Globals\EmailTemplates;
use App\Models\Globals\PaymentMethod;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendWelcomeEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/dashboard';
    protected $redirectTo = '/company-setting';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->common_controller = new CommonController();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'digits:10']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['phone_number'],
            'role' => 'user',
            'token' => sha1(time()),
        ]);

        //Company Entry
        $new_company = CompanySettings::create([
            'user_id' => $user['id'],
            'company_name' => $data['company_name'],
            'company_logo' => 'img/default_company.png',
            'signature_image' => 'img/default_signature.png',
        ]);

        session(['company'=>$new_company['id']]);

        //Payment Terms Entry
        $days_arr = [15,30,45,60];
        foreach ($days_arr as $days){
            PaymentTerms::create([
                'user_id' => $user['id'],
                'company_id' => $new_company['id'],
                'terms_name' => 'Net '.$days,
                'terms_days' => $days,
            ]);
        }

        //Expense Types Entry
        $expense_types = [
            'Advertising And Marketing',
            'Automobile Expense',
            'Bad Debt',
            'Bank Fees and Charges',
            'Consultant Expense',
            'Contract Assets',
            'Credit Card Charges',
            'Depreciation And Amortisation',
            'Depreciation Expense',
            'IT and Internet Expenses',
            'Janitorial Expense',
            'Lodging',
            'Meals and Entertainment',
            'Merchandise',
            'Office Supplies',
            'Other Expenses',
            'Postage',
            'Printing and Stationery',
            'Raw Materials And Consumables',
            'Rent Expense',
            'Repairs and Maintenance',
            'Salaries and Employee Wages',
            'Telephone Expense',
            'Transportation Expense',
            'Travel Expense'
        ];

        foreach($expense_types as $type) {
            ExpenseType::create([
                'user_id' => $user['id'],
                'company_id' => $new_company['id'],
                'name' => $type
            ]);
        }

        // Payment Method Entry
        $payment_methods = [
            'Cash',
            'Cheque',
            'Credit Card'
        ];

        foreach($payment_methods as $payment_method) {
            PaymentMethod::create([
                'user_id' => $user['id'],
                'method_name' => $payment_method
            ]);
        }

        // Email Template Entry
        $this->emailTemplateEntries($user['id']);

        $root = base_path() . '/public/upload/'.$user['id'];
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }

        $company_logo = url('assets/images/logo_2.png');
        $customer_name = ucwords($user['name']);
        $data = ['company_logo' => $company_logo,'customer_name' => $customer_name,'token'=>$user['token']];
        $data2 = ['company_logo' => $company_logo,'customer_name' => $customer_name];

        $to = $user['email'];

        // Send verification email
        Mail::to($to)->send(new VerifyEmail($data));

        // Send welcome email
        Mail::to($to)->send(new SignUpMail($data2));
        return $user;
    }

    public function emailTemplateEntries($user_id) {
        EmailTemplates::create([
            'user_id' => $user_id,
            'name' => 'Invoice',
            'slug' => 'invoice',
            'body' => '<p><span style="font-family: manrope, sans-serif;">Hi <strong>CustomerName</strong>,</span></p>
                        <h2><span style="font-family: manrope, sans-serif;">Thank you for your purchase!</span></h2>
                        <p><span style="font-family: manrope, sans-serif;">we are getting your order ready to be shipped. We will notify you when it has been sent.</span></p>
                        <p>&nbsp;</p>
                        <p><span style="font-family: manrope, sans-serif;">Kindly Download your invoice<strong>&nbsp;InvoiceNumber</strong></span></p>'
        ]);
        EmailTemplates::create([
            'user_id' => $user_id,
            'name' => 'Estimate',
            'slug' => 'estimate',
            'body' => '<p><span style="font-family: manrope, sans-serif;">Hi <strong>CustomerName</strong>,</span></p>
                        <h2><span style="font-family: manrope, sans-serif;">Thank you for your purchase!</span></h2>
                        <p><span style="font-family: manrope, sans-serif;">we are getting your order ready to be shipped. We will notify you when it has been sent.</span></p>
                        <p>&nbsp;</p>
                        <p><span style="font-family: manrope, sans-serif;">Kindly Download your estimate<strong>&nbsp;EstimateNumber</strong></span></p>'
        ]);
        EmailTemplates::create([
            'user_id' => $user_id,
            'name' => 'Credit Note',
            'slug' => 'credit-note',
            'body' => '<p><span style="font-family: manrope, sans-serif;">Hi <strong>CustomerName</strong>,</span></p>
                        <h2><span style="font-family: manrope, sans-serif;">Thank you for your purchase!</span></h2>
                        <p><span style="font-family: manrope, sans-serif;">we are getting your order ready to be shipped. We will notify you when it has been sent.</span></p>
                        <p>&nbsp;</p>
                        <p><span style="font-family: manrope, sans-serif;">Kindly Download your credit note<strong>&nbsp;CreditNoteNumber</strong></span></p>'
        ]);
    }

    public function send_welcome_mail($uid){
        $user = User::findOrFail($uid);
        $company_logo = url('assets/images/logo_2.png');
        $customer_name = ucwords($user['name']);
        $data = ['company_logo' => $company_logo,'customer_name' => $customer_name];
        $when = now()->addMinutes(10);
        Mail::to($user['email'])->later($when, new SignUpMail($data));
        /*$job = (new SendWelcomeEmail($uid))->onQueue('send_welcome_email');
        dispatch($job);*/
    }
}
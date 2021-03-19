<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Globals\SignUpMail;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\EmailTemplates;
use App\Models\Globals\ExpenseType;
use App\Models\Globals\PaymentMethod;
use App\Models\Globals\PaymentTerms;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();

            $already_user = User::where('email',$user->email)->first();

            if(!empty($already_user)){
                $input['google_id'] = $user->id;
                $already_user->update($input);

                Auth::login($already_user);
                return redirect('/dashboard');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at'=> Carbon::now()->format('Y-m-d h:i:s'),
                    'google_id'=> $user->id,
                    'password' => Hash::make('12345678'),
                    'role' => 'user',
                ]);

                Auth::login($newUser);

                //Company Entry
                $new_company = CompanySettings::create([
                    'user_id' => $newUser['id'],
                    'company_name' => $user->name,
                    'company_logo' => 'img/default_company.png',
                    'signature_image' => 'img/default_signature.png',
                ]);

                session(['company'=>$new_company['id']]);

                //Payment Terms Entry
                $days_arr = [15,30,45,60];
                foreach ($days_arr as $days){
                    PaymentTerms::create([
                        'user_id' => $newUser['id'],
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
                        'user_id' => $newUser['id'],
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
                        'user_id' => $newUser['id'],
                        'method_name' => $payment_method
                    ]);
                }

                // Email Template Entry
                $this->emailTemplateEntries($newUser['id']);

                $root = base_path() . '/public/upload/'.$newUser['id'];
                if (!file_exists($root)) {
                    mkdir($root, 0777, true);
                }

                // Send welcome email
                $this->send_welcome_mail($newUser['id'], false);

                Auth::login($newUser);
                return redirect('/dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
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

    public function send_welcome_mail($uid, $redirect = true){
        $user = User::findOrFail($uid);
        $company_logo = url('assets/images/logo_2.png');
        $customer_name = ucwords($user['name']);
        $data = ['company_logo' => $company_logo,'customer_name' => $customer_name];
        Mail::to($user['email'])->bcc('info@webplanex.com')->send(new SignUpMail($data));
    }
}

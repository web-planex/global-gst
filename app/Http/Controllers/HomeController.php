<?php

namespace App\Http\Controllers;

use App\Mail\Globals\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function send_contact_mail(Request $request){
//        $this->validate($request, [
//            'name' => 'required',
//            'email' => 'required|email',
//            'subject' => 'required',
//            'message' => 'required',
//        ]);

        $company_logo = url('assets/images/logo-light-icon_old.png');
        $customer_name = ucwords($request['name']);
        $from_mail = $request['email'];
        $subject = $request['subject'];
        $message = $request['message'];

        $data = [
            'company_logo' => $company_logo,
            'customer_name' => $customer_name,
            'from_mail' => $from_mail,
            'subject' => $subject,
            'message' => $message,
        ];
        Mail::to('test@webplanex.com')->send(new ContactMail($data));

        if (Mail::failures()) {
            return 0;
        }else{
            return 1;
        }
    }
}

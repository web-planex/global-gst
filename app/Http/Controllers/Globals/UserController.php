<?php

namespace App\Http\Controllers\Globals;

use App\CompanySettings;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function edit($id){
        $data['menu'] = 'Profile';
        $data['user'] = User::where('id',$id)->first();
        $data['company'] = CompanySettings::where('user_id',$id)->first();
        if(!empty($data['company'])){
            $data['company']['company_logo'] = substr($data['company']['company_logo'],6);
        }
        return view('user.edit_profile',$data);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        $input = $request->all();
        $user = User::where('id',$id)->first();
        $user->update($input);

        $company = CompanySettings::where('user_id',$id)->first();

        $in['user_id'] = $id;
        if($photo = $request->file('company_logo')){
            $in['company_logo'] = $this->image($photo,'company');
        }
        $in['company_name'] = !empty($request['company_name'])?$request['company_name']:'';
        $in['pan_no'] = !empty($request['pan_no'])?$request['pan_no']:'';
        $in['gstin'] = !empty($request['gstin'])?$request['gstin']:'';
        $in['company_email'] = !empty($request['company_email'])?$request['company_email']:'';
        $in['company_phone'] = !empty($request['company_phone'])?$request['company_phone']:'';
        $in['website'] = !empty($request['website'])?$request['website']:'';
        $in['street'] = !empty($request['street'])?$request['street']:'';
        $in['city'] = !empty($request['city'])?$request['city']:'';
        $in['state'] = !empty($request['state'])?$request['state']:'';
        $in['pincode'] = !empty($request['pincode'])?$request['pincode']:'';
        $in['country'] = !empty($request['country'])?$request['country']:'';

        empty($company)?CompanySettings::create($in):$company->update($in);

        \Session::flash('message', 'Profile has been updated successfully!');
        return redirect()->back();
    }

    public function edit_password($id){
        $data['menu'] = 'Password';
        $data['user'] = User::where('id',$id)->first();
        return view('user.edit_password',$data);
    }

    public function update_password(Request $request, $id){
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        $user = User::where('id',$id)->first();

        if(Hash::check($request['old_password'],$user['password'])){
            $input['password'] = Hash::make($request['password']);
            $user->update($input);

            \Session::flash('message', 'Your password is successfully changed!');
            return redirect()->back();
        }else{
            \Session::flash('error-message', 'Your old password is incorrect!');
            return redirect()->back();
        }
    }

    public function forgot_password(Request $request){
        $user = User::where('email',$request['recover_email'])->first();
        if(empty($user)){
            return 0;
        }else{
            $link = url('/reset-password/');
            $html = "";
            $html .= "<h4>Hi ".$user->name."</h4>";
            $html .= "<p style='font-size: 15px; margin-bottom: 20px;'>You recently requested to reset your password for your account. Click the button below to reset it.</p>";
            $html .= "<a href='".$link."'><button style='background-color: #fa7953;border-color: #fa6f46; color: #ffffff; border-radius: 0.3rem; padding: 0.5rem 1rem; font-size: 1.09375rem; line-height: 1.5; text-align: center;'>Click here to rest your password</button></a>";

            $to1=$request['recover_email'];
            $from1='noreply@webplanex.biz';
            $subject2='Password Reset';
            $mailcontent1=$html;
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: $from1\r\n";
            mail($to1,$subject2,$mailcontent1,$headers);
            return 1;
        }
    }

    public function reset_password(){
        return view('auth.passwords.reset');
    }

    public function change_password(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        $user = User::where('email',$request['email'])->first();

        if(empty($user)){
            throw ValidationException::withMessages([
                'email' => [trans('Entered email address is invalid!')],
            ]);
        }else{
            $input['password'] = Hash::make($request['password']);
            $user->update($input);

            \Session::flash('message', 'Your password is successfully changed!');
            return redirect('/login');
        }
    }
}

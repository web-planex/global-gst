<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Globals\Configuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\Globals\TestSMTPmail;

class ConfigurationController extends Controller
{
    public function __construct(){
        $this->middleware('multiauth:web');
    }

    public function index(){
        $user = Auth::guard()->user();
        $data['user_id'] = $user['id'];
        $data['shop'] = $this->Company();
        $data['emailConfiguration'] = Configuration::where('user_id',$user['id'])->where('company_id',$this->Company())->first();
        return view('globals.email-template.configuration',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request){
        $this->validate($request, [
            'from_email' => 'required|email',
            'from_name' => 'required',
            'smtp_host' => 'required',
            'smtp_username' => 'required',
            'smtp_password' => 'required',
            'smtp_port' => 'required',
            'smtp_security' => 'required',
        ]);
        $user = Auth::guard()->user();
        $company = $this->Company();
        $config = Configuration::where('user_id',$user['id'])->where('company_id',$company)->first();
        $input = $request->all();
        $input['user_id'] = $user['id'];
        $input['company_id'] = $company;
        if(empty($config)){
            Configuration::create($input);
            return redirect()->back()->with('message','Configuration has been created successfully!');
        }else{
            $config->update($input);
            return redirect()->back()->with('message','Configuration has been updated successfully!');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id){}

    public function reset_configuration(){
        $user = Auth::guard()->user();
        $company = $this->Company();
        $config = Configuration::where('user_id',$user['id'])->where('company_id',$company)->first();
        $config->delete();
        return redirect()->back()->with('message','Configuration has been reset successfully!');
    }

    public function test_configuration(Request $request)
    {
        try {
            $detail = $request->all();
            $this->smtp_host = $detail['smtp_host'];
            $this->smtp_port = $detail['smtp_port'];
            $this->from_email = $detail['from_email'];
            $this->from_name = $detail['from_name'];
            $this->smtp_encryption = $detail['smtp_security'];
            $this->smtp_username = $detail['smtp_username'];
            $this->smtp_password = $detail['smtp_password'];
            $config = array(
                'driver' => 'smtp',
                'host' => $this->smtp_host,
                'port' => $this->smtp_port,
                'from' => array('address' => $this->from_email, 'name' => $this->from_name),
                'encryption' => $this->smtp_encryption,
                'username' => $this->smtp_username,
                'password' => $this->smtp_password,
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            );
            Config::set('mail', $config);
            $result = Mail::to($this->from_email)->send(new TestSMTPmail($request->all()));
            $data = [
                'responce' => 1,
                'message' => 'Test success.'
            ];
            return $data;
        } catch (\Exception $e) {
            $data = [
                'responce' => 0,
                'message' => 'Test Fail, Please check your setting.'
            ];
            return $data;
        }
    }
}

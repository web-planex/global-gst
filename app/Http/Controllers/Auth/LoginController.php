<?php

namespace App\Http\Controllers\Auth;

use App\Models\Globals\CompanySettings;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
//        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request) {
        return (['email' => $request->email, 'password' => $request->password]);
    }

    public function showLoginForm() {
        if (Auth::guard('web')->check()) {
            return redirect('/dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function redirectTo() {
        $user_role = Auth::guard('web')->user();
        if ($user_role['role'] == 'user') {
            $company_count = CompanySettings::where('user_id',$user_role['id'])->get()->count();
            if($company_count > 1) {
                $session_company_selection = Session::get('company_selection');
                if(empty($session_company_selection)) {
                    session(['company_selection' => true]);
                }
            } else {
                $session = Session::get('company');
                if(empty($session)){
                    $company = CompanySettings::where('user_id',$user_role['id'])->orderBy('id','DESC')->first();
                    if(!empty($company)){
                        session(['company'=>$company['id']]);
                    }
                }
            }
            $this->redirectTo = '/dashboard';
        }else{
            Session::flush();
            \Session::flash('error-message', 'Invalid credential');
            $this->redirectTo = '/login';
        }
        return $this->redirectTo;
    }

    public function guard() {
        return Auth::guard('web');
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->forget('company_selection');
        $request->session()->forget('company');
        return redirect()->route('login');
    }
}

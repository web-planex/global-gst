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
    protected $redirectTo = '/dashboard';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user) {
        if($user->role == 'admin'){
            if($user->status == '1'){
                return redirect('/admin');
            }else{
                session()->flush();
                return redirect()->back()->withErrors(array('global' => "Sorry, Your Account Is In-Active Now."));
            }
        }else{
            $company_count = CompanySettings::where('user_id',$user->id)->get()->count();

            if($company_count > 1) {
                $session_company_selection = Session::get('company_selection');
                if(empty($session_company_selection)) {
                    session(['company_selection' => true]);
                }
            } else {
                $session = Session::get('company');
                if(empty($session)){
                    $company = CompanySettings::where('user_id',$user->id)->orderBy('id','DESC')->first();
                    if(!empty($company)){
                        session(['company'=>$company['id']]);
                    }
                }
            }
            return redirect('/dashboard');
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $this->guard()->logout();
        session()->flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        if($user['role'] == 'user'){
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect('/login')->withCookie(cookie('sb-login', '', -1));
        }else{
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect('admin/login')->withCookie(cookie('sb-login', '', -1));
        }


    }
}

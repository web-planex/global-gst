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

    public function logout() {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}

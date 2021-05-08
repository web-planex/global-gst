<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
//        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        if (Auth::guard('admin')->check()) {
            return redirect('admin/dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function guard() {
        return Auth::guard('admin');
    }

    public function redirectTo() {
        if (Auth::guard('admin')->check()) {
            $this->redirectTo = '/admin/dashboard';
        } else {
            $this->redirectTo = '/admin/login';
        }
        return $this->redirectTo;
    }

    protected function login(Request $request) {
        $data = $request->all();
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            // If validation fails redirect back to login.
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $userData = User::where('email', $request->email)->get()->first();
        if (!empty($userData)) {
            if ($userData->role != 'admin') {
                return redirect()->back()->withInput()->with('error-message','Invalid credential');
            }
        }else{
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }

        $userdata = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if (Auth::guard('admin')->validate($userdata)) {
            if (Auth::guard('admin')->attempt($userdata)) {
                if ($this->attemptLogin($request)) {
                    return $this->sendLoginResponse($request);
                }
            }
        } else {
            return redirect()->back()->withInput()->with('error-message','These credentials do not match our records.');
        }
    }

    protected function credentials(Request $request) {
        //return (['email' => $request->email, 'password' => $request->password, 'user_type' => 'BACKEND']);
        return (['email' => $request->email, 'password' => $request->password]);
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        $request->session()->forget('company_selection');
        $request->session()->forget('company');
        return redirect('admin/login');
    }

    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard('admin')->user()) ?: redirect()->intended($this->redirectPath());
    }
}

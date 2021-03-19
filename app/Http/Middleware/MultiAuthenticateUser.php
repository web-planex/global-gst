<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MultiAuthenticateUser
{
    protected $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function handle($request, Closure $next, $guard = 'web') {
        if (Auth::guard($guard)->check()) {
            return $next($request);
        } else {
            if ($guard == 'admin') {
                return redirect('admin/login');
            } elseif ($guard == 'web') {
                return redirect('/login');
            } else {
                return $next($request);
            }
        }
    }
}
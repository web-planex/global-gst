<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccessRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$access=0)
    {
        $user = Auth::user();
        if($user->role == 'admin'){
            if($access == 1){
                return $next($request);
            }else{
                return redirect('/admin');
            }
        }else{
            return redirect()->back();
        }
    }
}

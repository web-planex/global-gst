<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('multiauth:admin');
    }

    public function index(Request $request){
//        return Auth::guard('admin')->user();
        $data['menu'] = 'Dashboard';
        $data['total_users'] = User::where('role','!=','admin')->count();
        return view('admin.dashboard',$data);
    }
}

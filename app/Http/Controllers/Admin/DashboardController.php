<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){

        $this->middleware('AdminAccessRight');
    }

    public function index(Request $request){
        $data['menu'] = 'Dashboard';
        $data['total_users'] = User::where('role','!=','admin')->count();
        return view('admin.dashboard',$data);
    }
}

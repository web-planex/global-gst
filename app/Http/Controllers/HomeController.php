<?php

namespace App\Http\Controllers;

use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['menu'] = 'Dashboard';
        $data['total_expense'] = Expense::where('user_id',Auth::user()->id)->count();
        $data['total_payee'] = Payees::where('user_id',Auth::user()->id)->count();
        $data['total_payment_account'] = PaymentAccount::where('user_id',Auth::user()->id)->count();
        return view('dashboard',$data);
    }
}

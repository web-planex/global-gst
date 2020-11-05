<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Taxes;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['menu'] = 'Expense';
        $data['expense'] = Expense::orderBy('id','DESC')->paginate($this->pagination);
        return view('globals.expense.index',$data);
    }

    public function create(){
        $data['menu'] = 'Expense';
        $payees = payees::pluck('name','id')->toArray();
        $payment_accounts = PaymentAccount::pluck('name','id')->toArray();
        $data['taxes'] = Taxes::where('status', 1)->get();
        $data['payees'] = $payees;
        $data['payment_accounts'] = $payment_accounts;
        return view('globals.expense.create',$data);
    }
}

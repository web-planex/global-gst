<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Taxes;
use App\Models\Globals\ExpenseItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['menu'] = 'Expense';
        $data['expense'] = Expense::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate($this->pagination);
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
    
    public function insert(Request $request) {
        
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'payee' => 'required',
            'payment_account' => 'required',
            'payment_date' => 'required'
        ]);

        $expense = new Expense();
        $expense->user_id = $user->id;

        if($request['tax_type'] == 'exclusive') {
            $expense->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $expense->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $expense->tax_type = 3;
        }
        $expense->payee_id = $request['payee'];
        $expense->payment_account_id = $request['payment_account'];
        $expense->payment_date = date('Y-m-d', strtotime($request['payment_date']));
        $expense->payment_method = $request['payment_method'];
        $expense->ref_no = $request['ref_no'];

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request->has('submit')) {
            $expense->save();
            $expense_id = $expense->id;
        }
        $data = [];
        for($i=0;$i<count($request['item_name']);$i++)
        {
            $data = [
                'expense_id' => $expense_id,
                'item_name' => $request['item_name'][$i],
                'description' => $request['description'][$i],
                'quantity' => $request['quantity'][$i],
                'rate' => $request['rate'][$i],
                'amount' => $request['amount'][$i],
            ];
            ExpenseItems::create($data);
        }
        
        return redirect()->back()->with('message','Expense has been created successfully!');
    }
}

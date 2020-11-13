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
        $data['expense'] = Expense::join('payees', 'payees.id', '=', 'expenses.payee_id')
                ->join('payment_accounts','payment_accounts.id','=','expenses.payment_account_id')
                ->select('expenses.*','payees.name','payment_accounts.name as payment_account_name')->where('expenses.user_id',Auth::user()->id)
                ->orderBy('expenses.id','DESC')->paginate($this->pagination);
        return view('globals.expense.index',$data);
    }

    public function create(){
        $user = Auth::user();
        $data['menu'] = 'Expense';
        $payees = payees::where('user_id',$user->id)->pluck('name','id')->toArray();
        $payment_accounts = PaymentAccount::where('user_id',$user->id)->pluck('name','id')->toArray();
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
        $expense->tax_id = $request['taxes'];

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
        $expense->amount_before_tax = $request['amount_before_tax'];
        $expense->tax_amount = $request['tax_amount'];
        $expense->total = $request['total'];

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request->has('submit')) {
            $expense->save();
            $expense_id = $expense->id;
            $data = [];
            for($i=0;$i<count($request['item_name']);$i++) {
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
            return redirect('expense')->with('message','Expense has been created successfully!');
        }
    }
    
    public function edit($id) {
        $user = Auth::user();
        $data['menu'] = 'Expense';
        $data['expense'] = Expense::findOrFail($id);
        $data['expense_items'] = ExpenseItems::where('expense_id',$id)->get()->toArray();
        $data['payees'] = payees::where('user_id',$user->id)->pluck('name','id')->toArray();
        $data['payment_accounts'] = PaymentAccount::where('user_id',$user->id)->pluck('name','id')->toArray();
        $data['taxes'] = Taxes::where('status', 1)->get();
        return view('globals.expense.edit',$data);
    }
    
    public function update(Request $request, $id) {
        $expense = Expense::findOrFail($id);
        $expense->tax_id = $request['taxes'];

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
        $expense->amount_before_tax = $request['amount_before_tax'];
        $expense->tax_amount = $request['tax_amount'];
        $expense->total = $request['total'];

        $validator = Validator::make($request->all(), [
            'payee' => 'required',
            'payment_account' => 'required',
            'payment_date' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request->has('submit')) {
            $expense->update();
            ExpenseItems::where('expense_id',$id)->delete();
            
            $data = [];
            for($i=0;$i<count($request['item_name']);$i++) {
                $data = [
                    'expense_id' => $id,
                    'item_name' => $request['item_name'][$i],
                    'description' => $request['description'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                ];
                ExpenseItems::create($data);
            }
            return redirect('expense')->with('message','Expense has been updated successfully!');
        }
    }
    
    public function delete($id){
        $expense = Expense::where('id',$id)->first();
        $expense->delete();
        \Session::flash('error-message', 'Expense has been deleted successfully!');
        return redirect('expense');
    }
}

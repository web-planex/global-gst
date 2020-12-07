<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Suppliers;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Taxes;
use App\Models\Globals\ExpenseItems;
use WKPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['menu'] = 'Expense';
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date =  !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $query = Expense::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->select();
        
        if(isset($input_search) && !empty($input_search)){
             $method = '';
             $payee_id = '';
             $pay_account = '';
             
             foreach (Expense::$payment_method as $key => $type){
                 if(preg_grep('~'. strtolower($input_search).'~', array(strtolower($type)))){
                     $method .= $key.',';
                 }
             }
             
             $payees = Payees::where('name','like','%'.$input_search.'%')->select('id')->get();
             foreach($payees as $pid){
                 $payee_id .= $pid['id'].',';
             }
             
             $payment = PaymentAccount::where('name','like','%'.$input_search.'%')->select('id')->get();
             foreach($payment as $paid){
                 $pay_account .= $paid['id'].',';
             }
             
             $query->where(function($q) use($input_search, $method,$payee_id, $pay_account){
                        $q->orwhere('ref_no','like','%'.$input_search.'%');
                        $q->orwhereIn('payee_id', explode(',', $payee_id));
                        $q->orwhereIn('payment_account_id', explode(',', $pay_account));
                        $q->orwhereIn('payment_method', explode(',', $method));
              });
             $search = $input_search;
        }
        
        if(isset($start_date) && !empty($start_date)){
            $query->where('payment_date','>=',$start_date);
        }
        
        if(isset($end_date) && !empty($end_date)){
            $query->where('payment_date','<=',$end_date);
        }
        
        $data['search'] = $search;
        $data['start_date'] =$request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['expense'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        return view('globals.expense.index',$data);
    }

    public function create(){
        $user = Auth::user();
        $data['menu'] = 'Expense';
        $payees = payees::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
        $payment_accounts = PaymentAccount::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
        $data['taxes'] = Taxes::where('status', 1)->get();
        $data['all_taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
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
        $expense->company_id = $this->Company();

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
        $expense->memo = $request['memo'];

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
                    'tax_id' => $request['taxes'][$i],
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
        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
        $data['payment_accounts'] = PaymentAccount::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
        $data['taxes'] = Taxes::where('status', 1)->get();
        $data['all_taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
        return view('globals.expense.create',$data);
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'payee' => 'required',
            'payment_account' => 'required',
            'payment_date' => 'required'
        ]);

        $expense = Expense::where('id',$id)->first();
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
        $expense->amount_before_tax = $request['amount_before_tax'];
        $expense->tax_amount = $request['tax_amount'];
        $expense->total = $request['total'];
        $expense->memo = $request['memo'];

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if($request->has('submit')) {
            $expense->save();

            ExpenseItems::where('expense_id',$expense['id'])->delete();

            $expense_id = $expense->id;
            $data = [];
            for($i=0;$i<count($request['item_name']);$i++) {
                $data = [
                    'expense_id' => $expense_id,
                    'tax_id' => $request['taxes'][$i],
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

    public function payee_store(Request $request){
        $payeeValue = $request->all();
        $input=  array();
        $user = Auth::user();
        parse_str($payeeValue['data'], $input);
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();
        if($payeeValue['user_type']==1){
            $input['billing_rate'] = isset($input['billing_rate'])&&!empty($input['billing_rate'])?$input['billing_rate']:0;
            $input['apply_tds_for_supplier'] = isset($input['apply_tds_for_supplier'])&&!empty($input['apply_tds_for_supplier'])?1:0;
            $user_type = Suppliers::create($input);

            $payee['type'] = 1;
        }elseif ($payeeValue['user_type']==2){
            $input['hire_date'] = !empty($input['hire_date'])?date('y-m-d',strtotime($input['hire_date'])):"";
            $input['released'] =  !empty($input['released'])?date('y-m-d',strtotime($input['released'])):null;
            $input['date_of_birth'] =  !empty($input['date_of_birth'])?date('y-m-d',strtotime($input['date_of_birth'])):null;

            $user_type = Employees::create($input);

            $payee['type'] = 2;
        }else{
            $user_type = Customers::create($input);

            $payee['type'] = 3;
        }

        $payee['user_id'] = $user->id;
        $payee['company_id'] = $this->Company();
        $payee['name'] = $user_type['first_name'].' '.$user_type['last_name'];
        $payee['type_id'] = $user_type['id'];
        $new_payee = Payees::create($payee);

        $data['id'] = $new_payee['id'];
        $data['name'] = $new_payee['name'];

        return $data;
    }

    public function payment_account_store(Request $request){
        $paymentValue = $request->all();
        $input=  array();
        $user = Auth::user();
        parse_str($paymentValue['data'], $input);
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();
        $input['as_of'] = !empty($input['as_of'])?date("Y-m-d", strtotime($input['as_of'])):"";
        $paymentAccount = PaymentAccount::create($input);

        $data['id'] = $paymentAccount['id'];
        $data['name'] = $paymentAccount['name'];

        return $data;
    }
    
    public function download_pdf(Request $request, $id){
        $data['menu']  = 'Expense Voucher PDF';
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $data['expense'] = Expense::with('ExpenseItems')->where('id',$id)->first();
        $data['taxes'] = Taxes::where('status', 1)->get();
        $tax_count = 5;
        foreach($data['taxes'] as $tax) {
            $tax['tax_name'] == 'GST' ? $tax_count += 2 : $tax_count += 1;
        }
        $data['tax_count'] = $tax_count;
        
        if(!empty($data['expense']['ExpenseItems'])){
            foreach($data['expense']['ExpenseItems'] as $exp){
                    $tax = Taxes::where('id',$exp['tax_id'])->first();
                    $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
            }
        }        
        $data['expense']['total_in_word'] = $this->convert_digit_to_words($data['expense']['total']);
                
        $payee = Payees::where('id',$data['expense']['payee_id'])->first();
        if(!empty($payee)){
            if($payee['type']==1){
                $data['user'] = Suppliers::where('id',$payee['type_id'])->first();
            }elseif($payee['type']==2){
                $data['user'] = Employees::where('id',$payee['type_id'])->first();
            }else{
                $data['user'] = Customers::where('id',$payee['type_id'])->first();
            }
        }

        $data['name']  = 'Expense Voucher';
        $data['content'] = 'This is test pdf.';
        $pdf = new WKPDF($this->globalPdfOption());        
        $pdf->addPage(view('globals.expense.pdf_invoice',$data));

        if($request->output == 'download') {
            if (!$pdf->send('expense_invoice.pdf')) {
                $error = $pdf->getError();
                return $error;
            }
        } else {
            if (!$pdf->send()) {
                $error = $pdf->getError();
                return $error;
            }
        }
    }
}
<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\States;
use App\Models\Globals\Suppliers;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Taxes;
use App\Models\Globals\ExpenseItems;
use App\Models\Globals\Product;
use App\Models\Globals\PdfZips;
use WKPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Jobs\GenerateBulkExpense;
use Illuminate\Support\Facades\Log;
use App\Models\Globals\Job;
use App\Models\Globals\ExpenseType;
use App\Http\Controllers\Globals\CommonController;

class ExpenseController extends Controller
{
    protected $common_controller;
    public function __construct(){
        $this->middleware(['auth','verified']);
        $this->middleware('UserAccessRight');
        $this->middleware(['auth','verified'], ['except' => 'download_pdf']);
        $this->common_controller = new CommonController();
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

            foreach (Expense::$payment_method as $key => $type){
                if(preg_grep('~'. strtolower($input_search).'~', array(strtolower($type)))){
                    $method .= $key.',';
                }
            }

            $payees = Payees::where('name','like','%'.$input_search.'%')->select('id')->get();
            foreach($payees as $pid){
                $payee_id .= $pid['id'].',';
            }

            $query->where(function($q) use($input_search, $method,$payee_id){
                       $q->orwhere('ref_no','like','%'.$input_search.'%');
                       $q->orwhereIn('payee_id', explode(',', $payee_id));
                       $q->orwhereIn('payment_method', explode(',', $method));
             });
            $search = $input_search;
        }

        if(isset($start_date) && !empty($start_date)){
            $query->where('expense_date','>=',$start_date);
        }

        if(isset($end_date) && !empty($end_date)){
            $query->where('expense_date','<=',$end_date);
        }

        if(isset($request['payee']) && !empty($request['payee'])){
            $query->where('payee_id',$request['payee']);
        }
        if(isset($request['status']) && !empty($request['status'])){
            $query->where('status',$request['status']);
        }

        $data['search'] = $search;
        $data['start_date'] =$request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['selected_payee'] = $request['payee'];
        $data['status'] = $request['status'];
        $data['payees'] = Payees::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->pluck('name','id')->prepend('All Payee','')->toArray();
        $data['expense'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        $data['custom_column'] = [
            'Payee',
            'Expense Date',
            'Payment Method',
            'Ref No',
            'Note',
            'Status'
        ];
        return view('globals.expense.index',$data);
    }

    public function create(){
        $user = Auth::user();
        $data['menu'] = 'Expense';
        $payees = payees::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
        $data['taxes'] = Taxes::where('status', 1)->get();
        $taxes_without_cess = Taxes::where('is_cess', 0)->where('status', 1)->get();
        $taxes_with_cess = Taxes::where('is_cess', 1)->where('status', 1)->get();
        $taxes_without_cess_arr = [];
        $taxes_with_cess_arr = [];

        $a=0;
        foreach($taxes_without_cess as $tax) {
            $taxes_without_cess_arr[$a] = $tax['rate'].'_'.$tax['tax_name'];
            $a++;
        }
        $i=0;
        foreach($taxes_with_cess as $tax) {
            $taxes_with_cess_arr[$i] = $tax['rate'].'_'.$tax['tax_name'];
            $taxes_with_cess_arr[$i+1] = $tax['cess'].'_CESS';
            $i = $i+2;
        }
        $data['all_tax_labels'] = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
//        $final_tax_arr = [];
//        foreach($combine_tax_arr as $str) {
//            $arr = explode("_", $str, 2);
//            $rate = $arr[0];
//            $tax_name = $arr[1];
//            $final_tax_arr[(string)$rate] = $tax_name;
//        }
//        return $final_tax_arr;

        $data['all_taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
        $data['payees'] = $payees;
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['expense_types'] = ExpenseType::where('user_id',$user->id)->where('company_id',$this->Company())->get();
        return view('globals.expense.create',$data);
    }

    public function insert(Request $request) {
        $user = Auth::user();
        $this->validate($request, [
            'payee' => 'required',
            'expense_date' => 'required',
            'status' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
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
        $expense->expense_date = date('Y-m-d', strtotime($request['expense_date']));
        $expense->payment_method = $request['payment_method'];
        $expense->ref_no = $request['ref_no'];
        $expense->amount_before_tax = $request['amount_before_tax'];
        $expense->tax_amount = $request['tax_amount'];
        /*if($request['discount_type'] != '') {
            $expense->discount = $request['discount'];
        } else {
            $expense->discount = '';
        }
        $expense->discount_type = $request['discount_type'];*/
        $expense->total = $request['total'];
        $expense->memo = $request['memo'];

        if($photo = $request->file('files')){
            $expense->files = $this->allFiles($photo,$user->id.'/expense/expense_attachment');
        }
        $expense->status = $request['status'];
        if($request->has('submit')) {
            $expense->save();
            $expense_id = $expense->id;
            $data = [];
            for($i=0;$i<count($request['expense_type']);$i++) {
                $data = [
                    'expense_id' => $expense_id,
                    'tax_id' => $request['taxes'][$i],
                    'expense_type_id' => $request['expense_type'][$i],
                    'note' => $request['note'][$i],
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
        $data['expense']['file_name'] = '';
        if(!empty($data['expense']['files']) && file_exists($data['expense']['files'])){
            $ext = explode('/',$data['expense']['files']);
            $data['expense']['file_name'] = $ext[4];
            $file_ext = explode('.',$ext[4]);
            $data['expense']['file_ext'] = $file_ext[1];
        }
        $data['expense_items'] = ExpenseItems::where('expense_id',$id)->get()->toArray();
        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
        $data['taxes'] = Taxes::where('status', 1)->get();
        $taxes_without_cess = Taxes::where('is_cess', 0)->where('status', 1)->get();
        $taxes_with_cess = Taxes::where('is_cess', 1)->where('status', 1)->get();
        $taxes_without_cess_arr = [];
        $taxes_with_cess_arr = [];

        $a=0;
        foreach($taxes_without_cess as $tax) {
            $taxes_without_cess_arr[$a] = $tax['rate'].'_'.$tax['tax_name'];
            $a++;
        }
        $i=0;
        foreach($taxes_with_cess as $tax) {
            $taxes_with_cess_arr[$i] = $tax['rate'].'_'.$tax['tax_name'];
            $taxes_with_cess_arr[$i+1] = $tax['cess'].'_CESS';
            $i = $i+2;
        }
        $data['all_tax_labels'] = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
        $data['all_taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
        $data['products'] =Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] =Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['expense_types'] = ExpenseType::where('user_id',$user->id)->where('company_id',$this->Company())->get();
        return view('globals.expense.create',$data);
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $this->validate($request, [
            'payee' => 'required',
            'expense_date' => 'required',
            'status' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
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
        $expense->expense_date = date('Y-m-d', strtotime($request['expense_date']));
        $expense->payment_method = $request['payment_method'];
        $expense->ref_no = $request['ref_no'];
        $expense->amount_before_tax = $request['amount_before_tax'];
        $expense->tax_amount = $request['tax_amount'];
        /*if($request['discount_type'] != '') {
            $expense->discount = $request['discount'];
        } else {
             $expense->discount = '';
        }
        $expense->discount_type = $request['discount_type'];*/
        $expense->total = $request['total'];
        $expense->memo = $request['memo'];

        if($photo = $request->file('files')){
            $expense->files = $this->allFiles($photo,$user->id.'/expense/expense_attachment');
        }

        $expense->status = $request['status'];

        if($request->has('submit')) {
            $expense->save();
            ExpenseItems::where('expense_id',$expense['id'])->delete();

            $expense_id = $expense->id;
            $data = [];
            for($i=0;$i<count($request['expense_type']);$i++) {
                $data = [
                    'expense_id' => $expense_id,
                    'tax_id' => $request['taxes'][$i],
                    'expense_type_id' => $request['expense_type'][$i],
                    'note' => $request['note'][$i],
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
        $data['customer_id'] = $user_type['id'];
        $address = '';
        if($payeeValue['user_type']==3 && isset($request['section']) && !empty($request['section']) && $request['section'] == 'estimate'){
            $billing_state = States::where('id',$user_type['billing_state'])->first();
            $shipping_state = States::where('id',$user_type['shipping_state'])->first();
            $address .= '<div class="col-md-6">
                                <div class="card border-info mb-0" style="background-color: #f5f5f5;">
                                    <div class="card-header bg-primary">
                                        <h4 class="m-b-0 text-white">Billing Address</h4></div>
                                    <div class="card-body pt-2 pb-2">
                                        <p class="card-text mb-0">'.$user_type['billing_name'].'</p>
                                        <p class="card-text mb-0">'.$user_type['billing_phone'].'</p>
                                        <p class="card-text mb-0">'.$user_type['billing_street'].'</p>
                                        <p class="card-text mb-0">'.$user_type['billing_city'].' - '.$user_type['billing_pincode'].'</p>
                                        <p class="card-text mb-0">'.$billing_state['state_name'].'</p>
                                        <p class="card-text mb-0">India</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-info mb-0" style="background-color: #f5f5f5;">
                                    <div class="card-header bg-primary">
                                        <h4 class="m-b-0 text-white">Shipping Address</h4></div>
                                    <div class="card-body pt-2 pb-2">
                                        <p class="card-text mb-0">'.$user_type['shipping_name'].'</p>
                                        <p class="card-text mb-0">'.$user_type['shipping_phone'].'</p>
                                        <p class="card-text mb-0">'.$user_type['shipping_street'].'</p>
                                        <p class="card-text mb-0">'.$user_type['shipping_city'].' - '.$user_type['shipping_pincode'].'</p>
                                        <p class="card-text mb-0">'.$shipping_state['state_name'].'</p>
                                        <p class="card-text mb-0">India</p>
                                    </div>
                                </div>
                            </div>';
        }

        $data['address'] = $address;
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
        $user = Auth::user();
        $data['menu']  = 'Expense Voucher PDF';
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $state = States::where('id',$data['company']['state'])->first();
        $data['company']['state'] = $state['state_name'];
        $data['company']['state_code'] = $state['state_number'];
        $company_address_arr = [
            $data['company']['street'],
            $data['company']['city'],
            $data['company']['state'],
            $data['company']['pincode'],
            $data['company']['country'],
        ];

        $data['company']['address'] = implode(', ', $company_address_arr);

        $data['expense'] = Expense::with('ExpenseItems')->where('id',$id)->first();
        $data['taxes'] = Taxes::where('status', 1)->get();

        if(!empty($data['expense']['ExpenseItems'])){
            foreach($data['expense']['ExpenseItems'] as $exp){
                $tax = Taxes::where('id',$exp['tax_id'])->first();
                if($tax['is_cess'] == 0) {
                    $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                } else {
                    $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                }
            }
        }
        $data['expense']['total_in_word'] = $this->common_controller->convert_digit_to_words($data['expense']['total']);

        $payee = Payees::where('id',$data['expense']['payee_id'])->first();
        if(!empty($payee)){
            if($payee['type']==1){
                $data['user'] = Suppliers::where('id',$payee['type_id'])->first();
                $state = States::where('id',$data['user']['state'])->first();
                $data['user']['state'] = $state['state_name'];
                $data['user']['state_code'] = $state['state_number'];
                $data['user']['billing_state'] = $state['state_name'];
                $data['user']['billing_state_code'] = $state['state_number'];
                $data['user']['is_shipping'] = false;
                $address_arr = [
                    $data['user']['street'],
                    $data['user']['city'],
                    $data['user']['state'],
                    $data['user']['pincode'],
                    $data['user']['country']
                ];
                $data['user']['address'] = implode(', ', $address_arr);
            }elseif($payee['type']==2){
                $data['user'] = Employees::where('id',$payee['type_id'])->first();
                $state = States::where('id',$data['user']['state'])->first();
                $data['user']['state'] = $state['state_name'];
                $data['user']['billing_state'] = $state['state_name'];
                $data['user']['billing_state_code'] = $state['state_number'];
                $data['user']['state_code'] = $state['state_number'];
                $data['user']['is_shipping'] = false;
                $address_arr = [
                    $data['user']['street'],
                    $data['user']['city'],
                    $data['user']['state'],
                    $data['user']['pincode'],
                    $data['user']['country']
                ];
                $data['user']['address'] = implode(', ', $address_arr);
            }else{
                $data['user'] = Customers::where('id',$payee['type_id'])->first();
                $state = States::where('id',$data['user']['billing_state'])->first();
                $shipping_state = States::where('id',$data['user']['shipping_state'])->first();
                $data['user']['state'] = $state['state_name'];
                $data['user']['billing_state'] = $state['state_name'];
                $data['user']['shipping_state'] = $shipping_state['state_name'];
                $data['user']['billing_state_code'] = $state['state_number'];
                $data['user']['shipping_state_code'] = $shipping_state['state_number'];
                $data['user']['is_shipping'] = true;
                $billing_address_arr = [
                    $data['user']['billing_street'],
                    $data['user']['billing_city'],
                    $data['user']['billing_state'],
                    $data['user']['billing_pincode'],
                    $data['user']['billing_country']
                ];
                $data['user']['billing_address'] = implode(', ', $billing_address_arr);
                $shipping_address_arr = [
                    $data['user']['shipping_street'],
                    $data['user']['shipping_city'],
                    $data['user']['shipping_state'],
                    $data['user']['shipping_pincode'],
                    $data['user']['shipping_country']
                ];
                $data['user']['shipping_address'] = implode(', ', $shipping_address_arr);
            }
        }

        $taxes_without_cess = Taxes::where('is_cess', 0)->where('status', 1)->get();
        $taxes_with_cess = Taxes::where('is_cess', 1)->where('status', 1)->get();
        $taxes_without_cess_arr = [];
        $taxes_with_cess_arr = [];

        $a=0;
        foreach($taxes_without_cess as $tax) {
            $taxes_without_cess_arr[$a] = $tax['rate'].'_'.$tax['tax_name'];
            $a++;
        }
        $i=0;
        foreach($taxes_with_cess as $tax) {
            $taxes_with_cess_arr[$i] = $tax['rate'].'_'.$tax['tax_name'];
            $taxes_with_cess_arr[$i+1] = $tax['cess'].'_CESS';
            $i = $i+2;
        }
        $data['all_tax_labels'] = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $company = CompanySettings::select('company_name')->where('id',$this->Company())->first();
        $data['company_name'] = $company['company_name'];
        $data['expense_types'] = ExpenseType::where('user_id',$user->id)->where('company_id',$this->Company())->get();
        $data['expense']['status_image'] = '';

        if($data['expense']['status'] == 1) {
            $data['expense']['status_image'] = asset('images/pending_img.png');
        }elseif($data['expense']['status'] == 2) {
            $data['expense']['status_image'] = asset('images/paid_imag.png');
        }elseif($data['expense']['status'] == 3) {
            $data['expense']['status_image'] = asset('images/voided_imag.png');
        }

        $data['name'] = 'Expense Voucher';
        $data['content'] = 'This is test pdf.';
        $pdf = new WKPDF($this->common_controller->globalPdfOption());
        //return $data;
        $pdf->addPage(view('globals.expense.pdf_expense',$data));
//        return View('globals.expense.pdf_expense',$data);
        if($request->output == 'download') {
            if (!$pdf->send('expense_voucher.pdf')) {
                $error = $pdf->getError();
                return $error;
            }
        } else {
            if (!$pdf->send()) {
                $error = $pdf->getError();
                Log::error($error);
            }
        }
    }

    public function get_product(Request $request) {
        if($request['data'] != 0){
            $product = Product::where('id',$request['data'])->first();
            $data['description'] = $product['description'];
            $data['hsn_code'] = $product['hsn_code'];
            $data['price'] = $product['price'];
        }else{
            $user = Auth::user();
            $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->select('title','id')->get()->toArray();
        }
        return $data;
    }

    public function get_expense_type(Request $request) {
        if($request['data'] != 0){
            $expense_type = Product::where('id',$request['data'])->first();
            $data['description'] = $expense_type['description'];
        }else{
            $user = Auth::user();
            $data['expense_type'] = ExpenseType::where('user_id',$user->id)->where('company_id',$this->Company())->select('name','id')->get()->toArray();
        }
        return $data;
    }

    public function product_store(Request $request){
        $productValue = $request->all();
        $input=  array();
        $user = Auth::user();
        parse_str($productValue['data'], $input);
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();
        $input['status'] = 1;
        $product = Product::create($input);

        $data['id'] = $product['id'];
        $data['name'] = $product['title'];
        return $data;
    }

    public function expense_type_store(Request $request) {
        $expenseTypeValue = $request->all();
        $input=  array();
        $user = Auth::user();
        parse_str($expenseTypeValue['data'], $input);
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();

        $expense_type = ExpenseType::create($input);

        $data['id'] = $expense_type['id'];
        $data['name'] = $expense_type['name'];
        return $data;
    }

    public function delete_attachment(Request $request){
        $expense = Expense::where('id',$request['data'])->first();
        if(!empty($expense['files']) && file_exists($expense['files'])){
            unlink($expense['files']);
        }
        $input['files'] = null;
        $expense->update($input);
        return ;
    }

    public function multiple_pdf(Request $request){
        $user = Auth::user();
        $company_id = $this->Company();
        $checkboxes = $request['all_expenses_check'];
        $download_type = $request['download_type'];
        $job = (new GenerateBulkExpense($user,$company_id,$checkboxes,$download_type))->onQueue('multiple_expense_pdf');
        dispatch($job);
        return redirect('download-pdf-zip');
    }

    public function downloadPdfZip() {

        $user = Auth::user();
        $company_id = $this->Company();
        $company = CompanySettings::where('id',$company_id)->first();
        $job_id = $company['job_id'];
        $pdfZip = PdfZips::where('user_id',$user->id)->where('company_id',$company_id)->where('zip_type',1)->orderBy('id','DESC')->get();
        $job_details = Job::where('id',$job_id)->first();
        $job_status = '';
        if($job_details){
            if($job_details->attempts == 0){
                $job_status = "Pending";
            }
            if($job_details->attempts > 0 ){
                $job_status = "Processing";
            }
        } else {
            if($job_id != ""){
                $job_status = "Finished";
            }
        }
        $data = [
            'menu' => 'Expense',
            'user_id' => $user->id,
            'zip_files' => $pdfZip,
            'job_status' => $job_status
        ];
        return view('globals.expense.get_pdf_zip',$data);
    }
}

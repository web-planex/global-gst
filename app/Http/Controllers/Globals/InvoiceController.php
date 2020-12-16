<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Customers;
use App\Models\Globals\Expense;
use App\Models\Globals\ExpenseItems;
use App\Models\Globals\Invoice;
use App\Models\Globals\InvoiceItems;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Taxes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data['menu'] = 'Sales';
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date =  !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $query = Invoice::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->select();

        if(isset($input_search) && !empty($input_search)){
            $payee_id = '';

            $payees = Payees::where('name','like','%'.$input_search.'%')->select('id')->get();
            foreach($payees as $pid){
                $payee_id .= $pid['id'].',';
            }

            $query->where(function($q) use($input_search,$payee_id){
                $q->orwhereIn('customer_id', explode(',', $payee_id));
                $q->orwhere('customer_email','like','%'.$input_search.'%');
                $q->orwhere('place_of_supply','like','%'.$input_search.'%');
            });
            $search = $input_search;
        }

        if(isset($start_date) && !empty($start_date)){
            $query->where(function($q) use($start_date){
                $q->orwhere('invoice_date','>=',$start_date);
                $q->orwhere('due_date','>=',$start_date);
            });
        }

        if(isset($end_date) && !empty($end_date)){
            $query->where(function($q) use($end_date){
                $q->orwhere('invoice_date','<=',$end_date);
                $q->orwhere('due_date','<=',$end_date);
            });
        }

        $data['search'] = $search;
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['invoice'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        return view('globals.invoice.index',$data);
    }

    public function create()
    {
        $user = Auth::user();
        $data['menu'] = 'Sales';
        $payment_accounts = PaymentAccount::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
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
        $tax_without_cess = Taxes::where('is_cess',0)->where('status',1)->get();
        $data['all_taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Customer','')->toArray();
        $data['payment_accounts'] = $payment_accounts;
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        return view('globals.invoice.create',$data);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'customer' => 'required',
            'customer_email' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'place_of_supply' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $invoice = new Invoice();

        $invoice->user_id = $user->id;
        $invoice->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $invoice->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $invoice->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $invoice->tax_type = 3;
        }
        $invoice->customer_id = $request['customer'];
        $invoice->customer_email = $request['customer_email'];
        $invoice->invoice_date = date('Y-m-d', strtotime($request['invoice_date']));
        $invoice->due_date = date('Y-m-d', strtotime($request['due_date']));
        $invoice->place_of_supply = $request['place_of_supply'];
        $invoice->amount_before_tax = $request['amount_before_tax'];
        $invoice->tax_amount = $request['tax_amount'];
        $invoice->total = $request['total'];

        if($photo = $request->file('files')){
            $invoice->files = $this->allFiles($photo,$user->id.'/invoice/invoice_attachment');
        }

        if($request->has('submit')) {
            $invoice->save();
            $invoice_id = $invoice->id;
            $data = [];
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'invoice_id' => $invoice_id,
                    'tax_id' => $request['taxes'][$i],
                    'product_id' => $request['product'][$i],
                    'hsn_code' => $request['hsn_code'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                ];
                InvoiceItems::create($data);
            }
            return redirect('sales')->with('message','Sales has been created successfully!');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = Auth::user();
        $data['menu'] = 'Sales';
        $data['invoice'] = Invoice::findOrFail($id);
        $data['invoice']['file_name'] = '';
        if(!empty($data['invoice']['files']) && file_exists($data['invoice']['files'])){
            $ext = explode('/',$data['invoice']['files']);
            $data['invoice']['file_name'] = $ext[4];
        }
        $data['invoice_items'] = InvoiceItems::where('invoice_id',$id)->get()->toArray();
        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Customer','')->toArray();
        $data['payment_accounts'] = PaymentAccount::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('name','id')->toArray();
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
        return view('globals.invoice.create',$data);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $this->validate($request, [
            'customer' => 'required',
            'customer_email' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'place_of_supply' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $invoice = Invoice::where('id',$id)->first();

        $invoice->user_id = $user->id;
        $invoice->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $invoice->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $invoice->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $invoice->tax_type = 3;
        }
        $invoice->customer_id = $request['customer'];
        $invoice->customer_email = $request['customer_email'];
        $invoice->invoice_date = date('Y-m-d', strtotime($request['invoice_date']));
        $invoice->due_date = date('Y-m-d', strtotime($request['due_date']));
        $invoice->place_of_supply = $request['place_of_supply'];
        $invoice->amount_before_tax = $request['amount_before_tax'];
        $invoice->tax_amount = $request['tax_amount'];
        $invoice->total = $request['total'];
        
        if($photo = $request->file('files')){
            $invoice->files = $this->allFiles($photo,$user->id.'/invoice/invoice_attachment');
        }

        if($request->has('submit')) {
            $invoice->save();
            InvoiceItems::where('invoice_id',$invoice['id'])->delete();

            $invoice_id = $invoice->id;
            $data = [];
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'invoice_id' => $invoice_id,
                    'tax_id' => $request['taxes'][$i],
                    'product_id' => $request['product'][$i],
                    'hsn_code' => $request['hsn_code'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                ];
                InvoiceItems::create($data);
            }
            return redirect('sales')->with('message','Sales has been updated successfully!');
        }
    }

    public function destroy($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        $invoice->delete();
        \Session::flash('error-message', 'Sales has been deleted successfully!');
        return redirect('sales');
    }

    public function getEmail(Request $request){
        $payee = Payees::where('id',$request['data'])->first();
        $customer = Customers::where('id',$payee['type_id'])->first();
        return $customer['email'];
    }
}

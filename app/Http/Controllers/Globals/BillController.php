<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Globals\Bills;
use App\Models\Globals\BillItems;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Taxes;
use App\Models\Globals\Payees;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\PaymentMethod;
use App\Models\Globals\PaymentTerms;

class BillController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
    }

    public function index(Request $request) {
        $data['menu'] = 'Bill';
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date = !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $status = '';
        $query = Bills::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->select();

        if(isset($input_search) && !empty($input_search)){
            $payee_id = '';

            $payees = Payees::where('name','like','%'.$input_search.'%')->select('id')->get();
            foreach($payees as $pid){
                $payee_id .= $pid['id'].',';
            }

            $query->where(function($q) use($input_search,$payee_id){
                $q->orwhereIn('payee_id', explode(',', $payee_id));
                $q->orwhere('bill_no','like','%'.$input_search.'%');
            });
            $search = $input_search;
        }

        if(isset($start_date) && !empty($start_date)){
            $query->where(function($q) use($start_date){
                $q->orwhere('bill_date','>=',$start_date);
                $q->orwhere('due_date','>=',$start_date);
            });
        }

        if(isset($end_date) && !empty($end_date)){
            $query->where(function($q) use($end_date){
                $q->orwhere('bill_date','<=',$end_date);
                $q->orwhere('due_date','<=',$end_date);
            });
        }

        if(isset($request['status']) && !empty($request['status'])){
            $query->where(function($q) use($request){
                $q->orwhere('status',$request['status']);
            });
            $status = $request['status'];
        }

        $data['search'] = $search;
        $data['status'] = $status;
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['bills'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $data['payment_method'] = PaymentMethod::where('user_id',Auth::user()->id)->pluck('method_name', 'id')->toArray();
        return view('globals.bills.index',$data);
    }

    public function create() {
        $user = Auth::user();
        $data['menu'] = 'Bill';
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
        $data['payees'] = Payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Payee / Vendor','')->toArray();
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['payment_terms'] = PaymentTerms::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('terms_name', 'id')->toArray();
        return view('globals.bills.create',$data);
    }

    public function store(Request $request) {
        $user = Auth::user();
        $this->validate($request, [
            'bill_no' => 'required',
            'customer' => 'required',
            'bill_date' => 'required',
            'due_date' => 'required',
            'payment_method' => 'required',
            'payment_terms' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $bill = new Bills();

        $bill->user_id = $user->id;
        $bill->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $bill->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $bill->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $bill->tax_type = 3;
        }
        $bill->payee_id = $request['customer'];
        $bill->bill_date = date('Y-m-d', strtotime($request['bill_date']));
        $bill->payment_method = $request['payment_method'];
        $bill->bill_no = $request['bill_no'];
        $bill->due_date = date('Y-m-d', strtotime($request['due_date']));
        $bill->payment_term_id = $request['payment_terms'];
        $bill->discount_level = $request['discount_level'];
        $bill->amount_before_tax = $request['amount_before_tax'];
        $bill->tax_amount = $request['tax_amount'];
        $bill->total = $request['total'];
        $bill->status = 1;

        if($request['discount_type'] != '') {
            $bill->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $bill->discount = '';
        }
        $bill->discount_type = $request['discount_type'];
        $bill->memo = $request['memo'];
        if($photo = $request->file('files')){
            $bill->files = $this->allFiles($photo,$user->id.'/bill/bill_attachment');
        }
        if($request->has('submit')) {
            $bill->save();
            $bill_id = $bill->id;
            $data = [];
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'bill_id' => $bill_id,
                    'product_id' => $request['product'][$i],
                    'tax_id' => $request['taxes'][$i],
                    'hsn_code' => $request['hsn_code'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                ];
                BillItems::create($data);
            }
            return redirect('bills')->with('message','Bill has been created successfully!');
        }
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $user = Auth::user();
        $data['menu'] = 'Bill';
        $data['bill'] = Bills::findOrFail($id);
        $data['bill']['file_name'] = '';
        if(!empty($data['bill']['files']) && file_exists($data['bill']['files'])){
            $ext = explode('/',$data['bill']['files']);
            $data['bill']['file_name'] = $ext[4];
            $file_ext = explode('.',$ext[4]);
            $data['bill']['file_ext'] = $file_ext[1];
        }
        $data['bill_items'] = BillItems::where('bill_id',$id)->get()->toArray();
        $data['payees'] = Payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Payee / Vendor','')->toArray();
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
        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['payment_terms'] = PaymentTerms::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('terms_name', 'id')->toArray();
        return view('globals.bills.create',$data);
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $this->validate($request, [
            'bill_no' => 'required',
            'customer' => 'required',
            'bill_date' => 'required',
            'due_date' => 'required',
            'payment_method' => 'required',
            'payment_terms' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $bill = Bills::where('id',$id)->first();

        $bill->user_id = $user->id;
        $bill->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $bill->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $bill->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $bill->tax_type = 3;
        }
        $bill->payee_id = $request['customer'];
        $bill->bill_date = date('Y-m-d', strtotime($request['bill_date']));
        $bill->payment_method = $request['payment_method'];
        $bill->bill_no = $request['bill_no'];
        $bill->due_date = date('Y-m-d', strtotime($request['due_date']));
        $bill->payment_term_id = $request['payment_terms'];
        $bill->discount_level = $request['discount_level'];
        $bill->amount_before_tax = $request['amount_before_tax'];
        $bill->tax_amount = $request['tax_amount'];
        $bill->total = $request['total'];

        if($request['discount_type'] != '') {
            $bill->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $bill->discount = '';
        }
        $bill->discount_type = $request['discount_type'];
        $bill->memo = $request['memo'];
        if($photo = $request->file('files')){
            $bill->files = $this->allFiles($photo,$user->id.'/bill/bill_attachment');
        }

        if($request->has('submit')) {
            $bill->save();
            $bill_id = $bill->id;
            BillItems::where('bill_id',$bill_id)->delete();
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'bill_id' => $bill_id,
                    'product_id' => $request['product'][$i],
                    'tax_id' => $request['taxes'][$i],
                    'hsn_code' => $request['hsn_code'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                ];
                BillItems::create($data);
            }
            return redirect('bills')->with('message','Bill has been updated successfully!');
        }
    }

    public function destroy($id) {
        $bill = Bills::where('id',$id)->first();
        $bill->delete();
        \Session::flash('error-message', 'Bill has been deleted successfully!');
        return redirect('bills');
    }
    
    public function payment_terms_store(Request $request) {
        $all_payment_terms = $request->all();
        $input=  array();
        $user = Auth::user();
        parse_str($all_payment_terms['data'], $input);
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();

        $payment_terms = PaymentTerms::create($input);

        $data['id'] = $payment_terms['id'];
        $data['terms_name'] = $payment_terms['terms_name'];
        return $data;
    }
    
    public function delete_attachment(Request $request){
        $bill = Bills::where('id',$request['data'])->first();
        if(!empty($bill['files']) && file_exists($bill['files'])){
            unlink($bill['files']);
        }
        $input['files'] = null;
        $bill->update($input);
        return ;
    }

    public function make_payment(Request $request, $bid){
        $bill = Bills::where('id',$bid)->first();
        if(!empty($bill)){
            $input['payment_date'] = date('Y-m-d', strtotime($request['pdate']));
            $input['payment_method'] = $request['pmethod'];
            $input['bill_no'] = $request['billno'];
            $input['memo'] = $request['note'];
            $input['status'] = 2;
            $bill->update($input);
        }
        return ;
    }

    public function void($id) {
        $bill = Bills::where('id',$id)->first();
        $input['void_date'] = Carbon::now()->format('Y-m-d');
        $input['status'] = 3;
        $bill->update($input);
        \Session::flash('error-message', 'Bill has been voided successfully!');
        return redirect('bills');
    }
}

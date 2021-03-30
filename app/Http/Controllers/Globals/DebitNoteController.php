<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\Invoice;
use App\Models\Globals\DebitNote;
use App\Models\Globals\DebitNoteItems;
use App\Models\Globals\Job;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentMethod;
use App\Models\Globals\PaymentTerms;
use App\Models\Globals\PdfZips;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Taxes;
use Carbon\Carbon;
use WKPDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Globals\CommonController;
use App\Jobs\GenerateBulkDebitNote;

class DebitNoteController extends Controller
{
    protected $common_controller;
    public function __construct(){
        $this->middleware('multiauth:web');
        //$this->middleware(['auth','verified'], ['except' => 'download_pdf']);
//        $this->middleware('UserAccessRight');
        $this->common_controller = new CommonController();
    }

    public function index(Request $request){
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date = !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $status = '';
        $query = DebitNote::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->select();

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
                $q->orwhere('debit_note_date','>=',$start_date);
                $q->orwhere('due_date','>=',$start_date);
            });
        }

        if(isset($end_date) && !empty($end_date)){
            $query->where(function($q) use($end_date){
                $q->orwhere('debit_note_date','<=',$end_date);
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
        $data['debit_note'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $data['payment_method'] = PaymentMethod::where('user_id',Auth::user()->id)->pluck('method_name', 'id')->toArray();
        $data['custom_column'] = [
            'Debit Note No',
            'Customer',
            'Debit Note Date',
            'Due Date',
            'Total',
            'Notes'
        ];
        return view('globals.debit-note.index',$data);
    }

    public function create()
    {
        $user = Auth::user();
        $data['menu'] = 'Debit Note';
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
//        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Customer','')->toArray();

        $payees = Payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->get();
        $exp_user = array();
        $exp_user[''] = 'Select Customer';
        foreach ($payees as $pay){
            $pay_user = Customers::where('id',$pay['type_id'])->first();
            $exp_user[$pay->id] = $pay_user['display_name'];
        }
        $data['payees'] = $exp_user;

        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['payment_terms'] = PaymentTerms::where('user_id',$user->id)->where('company_id',$this->Company())->get();
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        $data['invoice_ids'] = Invoice::select('id','invoice_number','invoice_date')->where('user_id',$user->id)->where('company_id',$this->Company())->get()->toArray();
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        return view('globals.debit-note.create',$data);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'debit_note_date' => 'required',
            'debit_note_number' => 'required',
            'ref_invoice_id' => 'required',
            'ref_invoice_date' => 'required',
            'customer' => 'required',
            'due_date' => 'required',
            'payment_method' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $debit_note = new DebitNote();

        $debit_note->user_id = $user->id;
        $debit_note->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $debit_note->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $debit_note->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $debit_note->tax_type = 3;
        }
        $debit_note->customer_id = $request['customer'];
        $debit_note->debit_note_date = date('Y-m-d', strtotime($request['debit_note_date']));
        $debit_note->debit_note_number = $request['debit_note_number'];
        $debit_note->ref_invoice_id = $request['ref_invoice_id'];
        $debit_note->ref_invoice_date = date('Y-m-d', strtotime($request['ref_invoice_date']));
        $debit_note->due_date = date('Y-m-d', strtotime($request['due_date']));
        $debit_note->payment_method = $request['payment_method'];
        $debit_note->order_number = isset($request['order_number'])&&!empty($request['order_number'])?$request['order_number']:null;
        $debit_note->payment_term_id = $request['payment_terms'];
        $debit_note->discount_level = $request['discount_level'];
        $debit_note->shipping_charge_amount = $request['shipping_charge_amount'];
        $debit_note->shipping_charge = isset($request['shipping_charge'])&&!empty($request['shipping_charge'])?1:0;
        $debit_note->amount_before_tax = $request['amount_before_tax'];
        $debit_note->tax_amount = $request['tax_amount'];
        $debit_note->total = $request['total'];
        $debit_note->status = 1;

        if($request['discount_type'] != '') {
            $debit_note->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $debit_note->discount = '';
        }
        $debit_note->discount_type = $request['discount_type'];
        $debit_note->notes = $request['notes'];
        if($photo = $request->file('files')){
            $debit_note->files = $this->allFiles($photo,$user->id.'/debit_note/debit_note_attachment');
        }
        if($request->has('submit')) {
            $debit_note->save();
            $debit_note_id = $debit_note->id;
            $data = [];
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'debit_note_id' => $debit_note_id,
                    'product_id' => $request['product'][$i],
                    'tax_id' => $request['taxes'][$i],
                    'hsn_code' => $request['hsn_code'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                    'discount_type' => $request['discount_type_items'][$i]
                ];
                if($request['discount_type_items'][$i] != '') {
                    $data['discount'] = $request['discount_type_items'][$i]==2?str_replace( ',', '', $request['discount_items'][$i]):str_replace( ' %', '', $request['discount_items'][$i]);
                } else {
                    $data['discount'] = '';
                }

                $main_tax = Taxes::where('id',$request['taxes'][$i])->first();
                if($main_tax['is_cess']==1){
                    $debit_input['is_cess'] = 1;
                    $new_debit = DebitNote::where('id',$debit_note_id)->first();
                    $new_debit->update($debit_input);
                }

                DebitNoteItems::create($data);
            }
            return redirect('debit-notes')->with('message','Debit note has been created successfully!');
        }
    }

    public function edit($id) {
        $user = Auth::user();
        $data['menu'] = 'Debit Note';
        $data['debit_note'] = DebitNote::findOrFail($id);
        $customer = Customers::where('id',$data['debit_note']['Payee']['type_id'])->first();
        $billing_state = States::where('id',$customer['billing_state'])->first();
        $shipping_state = States::where('id',$customer['shipping_state'])->first();
        $data['debit_note']['customer'] = $customer;
        $data['debit_note']['customer']['billing_state_name'] = $billing_state['state_name'];
        $data['debit_note']['customer']['billing_state_code'] = $billing_state['state_number'];
        $data['debit_note']['customer']['shipping_state_name'] = $shipping_state['state_name'];
        $data['debit_note']['customer']['shipping_state_code'] = $shipping_state['state_number'];
        $data['debit_note']['file_name'] = '';
        if(!empty($data['debit_note']['files']) && file_exists($data['debit_note']['files'])){
            $ext = explode('/',$data['debit_note']['files']);
            $data['debit_note']['file_name'] = $ext[4];
            $file_ext = explode('.',$ext[4]);
            $data['debit_note']['file_ext'] = $file_ext[1];
        }
        $data['debit_note_items'] = DebitNoteItems::where('debit_note_id',$id)->get()->toArray();
//        $data['payees'] = Payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Payee / Vendor','')->toArray();
        $payees = Payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->get();
        $exp_user = array();
        $exp_user[''] = 'Select Customer';
        foreach ($payees as $pay){
            $pay_user = Customers::where('id',$pay['type_id'])->first();
            $exp_user[$pay->id] = $pay_user['display_name'];
        }
        $data['payees'] = $exp_user;
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
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['payment_terms'] = PaymentTerms::where('user_id',$user->id)->where('company_id',$this->Company())->get();
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        $data['invoice_ids'] = Invoice::select('id','invoice_number','invoice_date')->where('user_id',$user->id)->where('company_id',$this->Company())->get()->toArray();
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        return view('globals.debit-note.create',$data);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $this->validate($request, [
            'debit_note_date' => 'required',
            'debit_note_number' => 'required',
            'ref_invoice_id' => 'required',
            'ref_invoice_date' => 'required',
            'customer' => 'required',
            'due_date' => 'required',
            'payment_method' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $debit_note = DebitNote::where('id',$id)->first();

        $debit_note->user_id = $user->id;
        $debit_note->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $debit_note->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $debit_note->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $debit_note->tax_type = 3;
        }
        $debit_note->customer_id = $request['customer'];
        $debit_note->debit_note_date = date('Y-m-d', strtotime($request['debit_note_date']));
        $debit_note->debit_note_number = $request['debit_note_number'];
        $debit_note->ref_invoice_id = $request['ref_invoice_id'];
        $debit_note->ref_invoice_date = date('Y-m-d', strtotime($request['ref_invoice_date']));
        $debit_note->payment_method = $request['payment_method'];
        $debit_note->order_number = isset($request['order_number'])&&!empty($request['order_number'])?$request['order_number']:null;
        $debit_note->due_date = date('Y-m-d', strtotime($request['due_date']));
        $debit_note->payment_method = $request['payment_method'];
        $debit_note->payment_term_id = $request['payment_terms'];
        $debit_note->discount_level = $request['discount_level'];
        $debit_note->shipping_charge_amount = $request['shipping_charge_amount'];
        $debit_note->shipping_charge = isset($request['shipping_charge'])&&!empty($request['shipping_charge'])?1:0;
        $debit_note->amount_before_tax = $request['amount_before_tax'];
        $debit_note->tax_amount = $request['tax_amount'];
        $debit_note->total = $request['total'];

        if($request['discount_type'] != '') {
            $debit_note->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $debit_note->discount = '';
        }
        $debit_note->discount_type = $request['discount_type'];
        $debit_note->notes = $request['notes'];
        if($photo = $request->file('files')){
            $debit_note->files = $this->allFiles($photo,$user->id.'/debit_note/debit_note_attachment');
        }

        if($request->has('submit')) {
            $debit_note->save();
            $debit_note_id = $debit_note->id;
            DebitNoteItems::where('debit_note_id',$debit_note_id)->delete();
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'debit_note_id' => $debit_note_id,
                    'product_id' => $request['product'][$i],
                    'tax_id' => $request['taxes'][$i],
                    'hsn_code' => $request['hsn_code'][$i],
                    'quantity' => $request['quantity'][$i],
                    'rate' => $request['rate'][$i],
                    'amount' => $request['amount'][$i],
                    'discount_type' => $request['discount_type_items'][$i]
                ];
                if($request['discount_type_items'][$i] != '') {
                    $data['discount'] = $request['discount_type_items'][$i]==2?str_replace( ',', '', $request['discount_items'][$i]):str_replace( ' %', '', $request['discount_items'][$i]);
                } else {
                    $data['discount'] = '';
                }
                $main_tax = Taxes::where('id',$request['taxes'][$i])->first();
                if($main_tax['is_cess']==1){
                    $debit_input['is_cess'] = 1;
                    $new_debit = DebitNote::where('id',$debit_note_id)->first();
                    $new_debit->update($debit_input);
                }
                DebitNoteItems::create($data);
            }
            return redirect('debit-notes')->with('message','Debit note has been updated successfully!');
        }
    }

    public function destroy($id)
    {
        $debit_note = DebitNote::where('id',$id)->first();
        $debit_note->delete();
        \Session::flash('error-message', 'Debit note has been deleted successfully!');
        return redirect('debit-notes');
    }

    public function delete_attachment(Request $request)
    {
        $debit_note = DebitNote::where('id',$request['data'])->first();
        if(!empty($debit_note['files']) && file_exists($debit_note['files'])){
            unlink($debit_note['files']);
        }
        $input['files'] = null;
        $debit_note->update($input);
        return ;
    }
    
    public function download_pdf(Request $request, $id){
        $user = Auth::user();
        $data['menu']  = 'Debit Note';
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

        $data['debit_note'] = DebitNote::with('DebitNoteItems')->where('id',$id)->first();
        $data['taxes'] = Taxes::where('status', 1)->get();

        if(!empty($data['debit_note']['DebitNoteItems'])){
            $b=0;
            foreach($data['debit_note']['DebitNoteItems'] as $exp){
                $tax = Taxes::where('id',$exp['tax_id'])->first();
                if($tax['is_cess'] == 0) {
                    $data['debit_note']['DebitNoteItems'][$b]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    $data['debit_note']['DebitNoteItems'][$b]['tax_rate'] = $tax['rate'];
                } else {
                    $data['debit_note']['DebitNoteItems'][$b]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    $data['debit_note']['DebitNoteItems'][$b]['tax_rate'] = $tax['rate'];
                }
                $b++;
            }
        }

        $data['debit_note']['total_in_word'] = $this->common_controller->convert_digit_to_words($data['debit_note']['total']);

        $payee = Payees::where('id',$data['debit_note']['customer_id'])->first();
        $data['user'] = Customers::where('id',$payee['type_id'])->first();
        $state = States::where('id',$data['user']['billing_state'])->first();
        $shipping_state = States::where('id',$data['user']['shipping_state'])->first();
        $data['user']['state'] = $state['state_name'];
        $data['user']['billing_state'] = $state['state_name'];

        $data['user']['shipping_state'] = $shipping_state['state_name'];
        $data['user']['billing_state_code'] = $state['state_number'];
        $data['user']['shipping_state_code'] = $shipping_state['state_number'];
//        $data['user']['is_shipping'] = true;
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
        $data['debit_note']['status_image'] = '';
        $data['payment_method'] = PaymentMethod::select('method_name')->where('id',$data['debit_note']['payment_method'])->first();

        /*if($data['debit_note']['status'] == 1) {
            $data['debit_note']['status_image'] = asset('images/pending_img.png');
        }elseif($data['debit_note']['status'] == 2) {
            $data['debit_note']['status_image'] = asset('images/paid_imag.png');
        }elseif($data['debit_note']['status'] == 3) {
            $data['debit_note']['status_image'] = asset('images/voided_imag.png');
        }*/
        $data['invoice'] = Invoice::select('invoice_number')->where('id',$data['debit_note']['Invoice']['id'])->first();

        $data['name'] = 'Debit Note';

        if($data['company']['pdf_template'] == 1){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>28.1, 'ml'=>0, 'footer'=>'globals.debit-note.template.template_1_footer'];
        }elseif ($data['company']['pdf_template'] == 2){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>10, 'ml'=>0, 'footer'=>'globals.debit-note.template.template_2_footer'];
        }elseif ($data['company']['pdf_template'] == 3){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>12, 'ml'=>0, 'footer'=>'globals.debit-note.template.template_3_footer'];
        }elseif ($data['company']['pdf_template'] == 4){
            $pdf_option = ['mt'=>10, 'mr'=>10, 'mb'=>10, 'ml'=>10, 'footer'=>'globals.debit-note.template.template_4_footer'];
        }else{
            $pdf_option = ['mt'=>10, 'mr'=>10, 'mb'=>10, 'ml'=>10, 'footer'=>'globals.debit-note.template.template_5_footer'];
        }

        $pdf = new WKPDF($this->common_controller->globalPdfOption($pdf_option));
        $pdf->addPage(view('globals.debit-note.template.template_'.$data['company']['pdf_template'],$data));

        if($request->output == 'download') {
            if (!$pdf->send('debit_note.pdf')) {
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

    public function multiple_pdf(Request $request){
        $user = Auth::user();
        $company_id = $this->Company();
        $checkboxes = $request['all_debit_note_check'];
        $download_type = $request['download_type'];
        $job = (new GenerateBulkDebitNote($user,$company_id,$checkboxes,$download_type))->onQueue('multiple_debit_note_pdf');
        dispatch($job);
        return redirect('download-debit-notes-pdf-zip');
    }

    public function downloadPdfZip() {

        $user = Auth::user();
        $company_id = $this->Company();
        $company = CompanySettings::where('id',$company_id)->first();
        $job_id = $company['job_id'];
        $pdfZip = PdfZips::where('user_id',$user->id)->where('company_id',$company_id)->where('zip_type',6)->orderBy('id','DESC')->get();
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
            'menu' => 'Debit Note',
            'user_id' => $user->id,
            'zip_files' => $pdfZip,
            'job_status' => $job_status
        ];
        return view('globals.debit-note.get_pdf_zip',$data);
    }
}

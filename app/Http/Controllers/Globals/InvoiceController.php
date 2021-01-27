<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateBlukCreditNote;
use App\Jobs\GenerateBlukSalesInvoice;
use App\Models\Globals\Bills;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Expense;
use App\Models\Globals\ExpenseItems;
use App\Models\Globals\GeneratedInvoiceList;
use App\Models\Globals\Invoice;
use App\Models\Globals\InvoiceItems;
use App\Models\Globals\Job;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\PaymentMethod;
use App\Models\Globals\PaymentTerms;
use App\Models\Globals\PdfZips;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Suppliers;
use App\Models\Globals\Taxes;
use Carbon\Carbon;
use Symfony\Component\CssSelector\Parser\Reader;
use WKPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\Globals\InvoiceMail;
use App\Mail\Globals\CreditNoteMail;
use App\Models\Globals\EmailTemplates;

class InvoiceController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified'], ['except' => 'download_pdf']);
    }

    public function index(Request $request){
        $data['menu'] = 'Invoices';
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date = !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $status = '';
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
        $data['invoice'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $data['payment_method'] = PaymentMethod::where('user_id',Auth::user()->id)->pluck('method_name', 'id')->toArray();
        $data['custom_column'] = [
            'Invoice No',
            'Customer',
            'Invoice Date',
            'Due Date',
            'Notes',
            'Status'
        ];
        return view('globals.invoice.index',$data);
    }

    public function create(){
        $user = Auth::user();
        $data['menu'] = 'Invoices';
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
        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['payment_terms'] = PaymentTerms::all();
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        return view('globals.invoice.create',$data);
    }

    public function store(Request $request){
        $user = Auth::user();
        $this->validate($request, [
            'customer' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
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
        $invoice->invoice_date = date('Y-m-d', strtotime($request['invoice_date']));
        $invoice->due_date = date('Y-m-d', strtotime($request['due_date']));
        $invoice->payment_date = isset($request['payment_date'])&&!empty($request['payment_date'])?date('Y-m-d', strtotime($request['payment_date'])):null;
        $invoice->amount_before_tax = $request['amount_before_tax'];
        $invoice->tax_amount = $request['tax_amount'];
        $invoice->payment_method = isset($request['payment_method'])&&!empty($request['payment_method'])?$request['payment_method']:null;
        $invoice->order_number = isset($request['order_number'])&&!empty($request['order_number'])?$request['order_number']:null;
        $invoice->reference_number = isset($request['reference_number'])&&!empty($request['reference_number'])?$request['reference_number']:null;
        $invoice->shipping_charge_amount = $request['shipping_charge_amount'];
        $invoice->shipping_charge = isset($request['shipping_charge'])&&!empty($request['shipping_charge'])?1:0;
        $invoice->status = $request['status'];
        $invoice->payment_terms = isset($request['payment_terms'])&&!empty($request['payment_terms'])?$request['payment_terms']:null;
        $invoice->discount_level = $request['discount_level'];

        $company = CompanySettings::where('id',$this->Company())->first();
        $total_invoice = Invoice::count();

        if(empty($company['invoice_prefix']) && empty($company['invoice_number'])){
            $invoice->invoice_number = $total_invoice + 1;
            $input['invoice_number'] = $invoice->invoice_number;
            $company->update($input);
        }elseif(!empty($company['invoice_prefix']) && !empty($company['invoice_number'])){
            $invoice->invoice_number = $company['invoice_prefix'].'/'.$company['invoice_number'];
            $input['invoice_number'] = $company['invoice_number'] + 1;
            $company->update($input);
        }elseif(empty($company['invoice_prefix']) && !empty($company['invoice_number'])){
            $invoice->invoice_number = $company['invoice_number'];
            $input['invoice_number'] = $company['invoice_number'] + 1;
            $company->update($input);
        }elseif(!empty($company['invoice_prefix']) && empty($company['invoice_number'])){
            $e_no = $total_invoice + 1;
            $invoice->invoice_number = $company['invoice_prefix'].'/'.$e_no;
            $input['invoice_number'] = $company['invoice_number'] + 1;
            $company->update($input);
        }

        if(in_array($request['status'],[3,4])){
            if(empty($company['credit_note_prefix']) && empty($company['credit_note_number'])){
                $invoice->credit_note_number = $total_invoice + 1;
                $input['credit_note_number'] = $invoice->credit_note_number;
                $company->update($input);
            }elseif(!empty($company['credit_note_prefix']) && !empty($company['credit_note_number'])){
                $invoice->credit_note_number = $company['credit_note_prefix'].'/'.$company['credit_note_number'];
                $input['credit_note_number'] = $company['credit_note_number'] + 1;
                $company->update($input);
            }elseif(empty($company['credit_note_prefix']) && !empty($company['credit_note_number'])){
                $invoice->credit_note_number = $company['credit_note_number'];
                $input['credit_note_number'] = $company['credit_note_number'] + 1;
                $company->update($input);
            }elseif(!empty($company['credit_note_prefix']) && empty($company['credit_note_number'])){
                $e_no = $total_invoice + 1;
                $invoice->credit_note_number = $company['credit_note_prefix'].'/'.$e_no;
                $input['credit_note_number'] = $company['credit_note_number'] + 1;
                $company->update($input);
            }
        }

        if($request['discount_type'] != '') {
            $invoice->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $invoice->discount = '';
        }
        $invoice->discount_type = $request['discount_type'];
        $invoice->total = $request['total'];
        $invoice->notes = $request['notes'];

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
                    'discount_type' => $request['discount_type_items'][$i]
                ];
                if($request['discount_type_items'][$i] != '') {
                    $data['discount'] = $request['discount_type_items'][$i]==2?str_replace( ',', '', $request['discount_items'][$i]):str_replace( ' %', '', $request['discount_items'][$i]);
                } else {
                    $data['discount'] = '';
                }
                InvoiceItems::create($data);
            }
            // Send invoice email to customer
            $this->send_invoice_mail($invoice_id, false);
            return redirect('sales')->with('message','Invoice has been created successfully!');
        }
    }

    public function edit($id) {
        $user = Auth::user();
        $data['menu'] = 'Invoices';
        $data['invoice'] = Invoice::findOrFail($id);
        $customer = Customers::where('id',$data['invoice']['Payee']['type_id'])->first();
        $billing_state = States::where('id',$customer['billing_state'])->first();
        $shipping_state = States::where('id',$customer['shipping_state'])->first();

        $data['invoice']['customer'] = $customer;
        $data['invoice']['customer']['billing_state_name'] = $billing_state['state_name'];
        $data['invoice']['customer']['shipping_state_name'] = $shipping_state['state_name'];
        $data['invoice']['file_name'] = '';
        if(!empty($data['invoice']['files']) && file_exists($data['invoice']['files'])){
            $ext = explode('/',$data['invoice']['files']);
            $data['invoice']['file_name'] = $ext[4];
            $file_ext = explode('.',$ext[4]);
            $data['invoice']['file_ext'] = $file_ext[1];
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
        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['products'] =Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] =Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['payment_terms'] = PaymentTerms::all();
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        return view('globals.invoice.create',$data);
    }

    public function update(Request $request, $id){
        $user = Auth::user();
        $this->validate($request, [
            'customer' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
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
        $invoice->invoice_date = date('Y-m-d', strtotime($request['invoice_date']));
        $invoice->due_date = date('Y-m-d', strtotime($request['due_date']));
        $invoice->payment_date = isset($request['payment_date'])&&!empty($request['payment_date'])?date('Y-m-d', strtotime($request['payment_date'])):null;
        $invoice->amount_before_tax = $request['amount_before_tax'];
        $invoice->tax_amount = $request['tax_amount'];
        $invoice->payment_method = $request['payment_method'];
        $invoice->order_number = isset($request['order_number'])&&!empty($request['order_number'])?$request['order_number']:null;
        $invoice->reference_number = isset($request['reference_number'])&&!empty($request['reference_number'])?$request['reference_number']:null;
        $invoice->shipping_charge_amount = $request['shipping_charge_amount'];
        $invoice->shipping_charge = isset($request['shipping_charge'])&&!empty($request['shipping_charge'])?1:0;
        $invoice->status = $request['status'];
        $invoice->payment_terms = isset($request['payment_terms'])&&!empty($request['payment_terms'])?$request['payment_terms']:null;
        $invoice->discount_level = $request['discount_level'];

        $company = CompanySettings::where('id',$this->Company())->first();
        $total_invoice = Invoice::count();
        if(in_array($request['status'],[3,4]) && empty($invoice['credit_note_number'])){
            if(empty($company['credit_note_prefix']) && empty($company['credit_note_number'])){
                $invoice->credit_note_number = $total_invoice + 1;
                $input['credit_note_number'] = $invoice->credit_note_number;
                $company->update($input);
            }elseif(!empty($company['credit_note_prefix']) && !empty($company['credit_note_number'])){
                $invoice->credit_note_number = $company['credit_note_prefix'].'/'.$company['credit_note_number'];
                $input['credit_note_number'] = $company['credit_note_number'] + 1;
                $company->update($input);
            }elseif(empty($company['credit_note_prefix']) && !empty($company['credit_note_number'])){
                $invoice->credit_note_number = $company['credit_note_number'];
                $input['credit_note_number'] = $company['credit_note_number'] + 1;
                $company->update($input);
            }elseif(!empty($company['credit_note_prefix']) && empty($company['credit_note_number'])){
                $e_no = $total_invoice + 1;
                $invoice->credit_note_number = $company['credit_note_prefix'].'/'.$e_no;
                $input['credit_note_number'] = $company['credit_note_number'] + 1;
                $company->update($input);
            }
        }

        if($request['discount_type'] != '') {
            $invoice->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $invoice->discount = '';
        }
        $invoice->discount_type = $request['discount_type'];
        $invoice->total = $request['total'];
        $invoice->notes = $request['notes'];

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
                    'discount_type' => $request['discount_type_items'][$i]
                ];
                if($request['discount_type_items'][$i] != '') {
                    $data['discount'] = $request['discount_type_items'][$i]==2?str_replace( ',', '', $request['discount_items'][$i]):str_replace( ' %', '', $request['discount_items'][$i]);
                } else {
                    $data['discount'] = '';
                }
                InvoiceItems::create($data);
            }
            return redirect('sales')->with('message','Invoice has been updated successfully!');
        }
    }

    public function destroy($id){
        $invoice = Invoice::where('id',$id)->first();
        if(!empty($invoice['files']) && file_exists($invoice['files'])){
            unlink($invoice['files']);
        }
        $invoice->delete();
        \Session::flash('error-message', 'Invoice has been deleted successfully!');
        return redirect()->back();
    }

    public function getEmail(Request $request){
        $payee = Payees::where('id',$request['data'])->first();
        $customer = Customers::where('id',$payee['type_id'])->first();
        return $customer['email'];
    }

    public function delete_attachment(Request $request){
        $invoice = Invoice::where('id',$request['data'])->first();
        if(!empty($invoice['files']) && file_exists($invoice['files'])){
            unlink($invoice['files']);
        }
        $input['files'] = null;
        $invoice->update($input);
        return ;
    }

    public function download_pdf(Request $request, $id){
        $data['invoice'] = Invoice::with('InvoiceItems')->where('id',$id)->first();
        $user_id = $data['invoice']['user_id'];
        $company_id = $data['invoice']['company_id'];
        $data['invoice_type'] = isset($request['download'])&&$request['download']==1?'Original':(isset($request['download'])&&$request['download']==2?'Duplicate':(isset($request['download'])&&$request['download']==3?'Triplicate':'Original'));
        $data['menu']  = isset($request['type'])&&$request['type']=='credit_note'?'Credit Note':'Tax Invoice';
        $data['print_type']  = isset($request['type'])&&$request['type']=='credit_note'?2:1;
        $data['company'] = CompanySettings::where('id',$company_id)->first();
        $state = States::where('id',$data['company']['state'])->first();
        $data['company']['state'] = $state['state_name'];
        $data['company']['state_code'] = $state['state_number'];
        $data['invoice']['status_image'] = $data['invoice']['status']==1?"pending_img.png":($data['invoice']['status']==2?"paid_imag.png":"voided_imag.png");
        $data['invoice']['payment_method'] = $data['invoice']['payment_method']==1?"Cash":($data['invoice']['payment_method']==2?"Cheque":"Credit Card");

        /*Count Discount Price*/
        if($data['invoice']['discount_type']==1){
            $main_total = $data['invoice']['amount_before_tax'] + $data['invoice']['tax_amount'];
            $discount = ($main_total / 100) * $data['invoice']['discount'];
            $data['invoice']['discount_price'] = number_format($discount,2);
        }else{
            $data['invoice']['discount_price'] = $data['invoice']['discount'];
        }
        $data['taxes'] = Taxes::where('status', 1)->get();
        $tax_count = 5;
        foreach($data['taxes'] as $tax) {
            $tax['tax_name'] == 'GST' ? $tax_count += 2 : $tax_count += 1;
        }
        $data['tax_count'] = $tax_count;

        if(!empty($data['invoice']['InvoiceItems'])){
            foreach($data['invoice']['InvoiceItems'] as $item){
                $tax = Taxes::where('id',$item['tax_id'])->first();
                if($tax['is_cess'] == 0) {
                    $item['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                } else {
                    $item['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                }
            }
        }
        $data['invoice']['total_in_word'] = $this->convert_digit_to_words($data['invoice']['total']);

        $payee = Payees::where('id',$data['invoice']['customer_id'])->first();
        if(!empty($payee)){
            $data['user'] = Customers::where('id',$payee['type_id'])->first();
            $state = States::where('id',$data['user']['billing_state'])->first();
            $shipping_state = States::where('id',$data['user']['shipping_state'])->first();
            $data['user']['state'] = $state['state_name'];
            $data['user']['state_code'] = $state['state_number'];

            $data['user']['shipping_state'] = $shipping_state['state_name'];
            $data['user']['shipping_state_code'] = $shipping_state['state_number'];
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
        $data['products'] = Product::where('user_id',$user_id)->where('company_id',$company_id)->where('status',1)->get();
        $company = CompanySettings::select('company_name')->where('id',$company_id)->first();
        $data['company_name'] = $company['company_name'];
        $data['name']  = 'Sales Voucher';
        $data['content'] = 'This is test pdf.';
        $pdf = new WKPDF($this->globalPdfOption());

//        return view('globals.invoice.pdf_invoice',$data);

        $pdf->addPage(view('globals.invoice.pdf_invoice',$data));
        if($request->output == 'download') {
            if (!$pdf->send('sales_invoice_'.$data['invoice_type'].'.pdf')) {
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
        $checkboxes = $request['all_sales_check'];
        $download_type = $request['download_type'];
        $invoice_type = $request['invoice_type'];
        $job = (new GenerateBlukSalesInvoice($user,$company_id,$checkboxes,$download_type,$invoice_type))->onQueue('multiple_sales_invoice_pdf');
        dispatch($job);
        return redirect('download-invoice-pdf-zip');
    }

    public function downloadPdfZip() {
        date_default_timezone_set('Asia/Kolkata');
        $user = Auth::user();
        $company_id = $this->Company();
        $company = CompanySettings::where('id',$company_id)->first();
        $job_id = $company['job_id'];
        $pdfZip = PdfZips::where('user_id',$user->id)->where('company_id',$company_id)->where('zip_type',2)->orderBy('id','DESC')->get();
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
            'menu' => 'Sales',
            'user_id' => $user->id,
            'zip_files' => $pdfZip,
            'job_status' => $job_status
        ];
        return view('globals.invoice.get_pdf_zip',$data);
    }

    public function credit_notes(Request $request){
        $data['menu'] = 'Credit Notes';
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date = !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $status = '';
        $query = Invoice::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->whereIn('status',[3,4])->select();

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
        $data['status'] = $status;
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['credit_notes'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $data['custom_column'] = [
            'Invoice No',
            'Credit Note No',
            'Customer',
            'Invoice Date',
            'Due Date',
            'Total Tax',
            'Status',
            'Total'
        ];
        return view('globals.invoice.credit_note',$data);
    }

    public function multiple_credit_note_pdf(Request $request){
        $user = Auth::user();
        $company_id = $this->Company();
        $checkboxes = $request['all_sales_check'];
        $download_type = $request['download_type'];
        $invoice_type = $request['invoice_type'];
        $job = (new GenerateBlukCreditNote($user,$company_id,$checkboxes,$download_type,$invoice_type))->onQueue('multiple_credit_note_pdf');
        dispatch($job);
        return redirect('download-credit-note-pdf-zip');
    }

    public function downloadCreditNotePdfZip() {
        date_default_timezone_set('Asia/Kolkata');
        $user = Auth::user();
        $company_id = $this->Company();
        $company = CompanySettings::where('id',$company_id)->first();
        $job_id = $company['job_id'];
        $pdfZip = PdfZips::where('user_id',$user->id)->where('company_id',$company_id)->where('zip_type',3)->orderBy('id','DESC')->get();
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
            'menu' => 'Credit Note',
            'user_id' => $user->id,
            'zip_files' => $pdfZip,
            'job_status' => $job_status
        ];
        return view('globals.invoice.get_credit_note_pdf_zip',$data);
    }

    public function void($id) {
        $company = CompanySettings::where('id',$this->Company())->first();

        $invoice = Invoice::where('id',$id)->first();
        $input['void_date'] = Carbon::now()->format('Y-m-d');

        if(!empty($company['credit_note_prefix'])){
            $invoice->credit_note_number = $company['credit_note_prefix'].'/'.$company['credit_note_number'];
        }elseif (empty($company['credit_note_prefix']) && !empty($company['credit_note_number'])){
            $invoice->credit_note_number = $company['credit_note_number'];
        }else{
            $invoice->credit_note_number = 1;
        }
        $input['status'] = 3;
        $invoice->update($input);

        $input['credit_note_number'] = $company['credit_note_number']+1;
        $company->update($input);
        \Session::flash('error-message', 'Invoice has been voided successfully!');
        return redirect('sales');
    }

    public function make_payment(Request $request, $in_id){
        $invoice = Invoice::where('id',$in_id)->first();
        if(!empty($invoice)){
            $input['payment_date'] = date('Y-m-d', strtotime($request['pdate']));
            $input['payment_method'] = $request['pmethod'];
            $input['invoice_number'] = $request['invoice_number'];
            $input['notes'] = $request['note'];
            $input['status'] = 2;
            $invoice->update($input);
        }
        return ;
    }
    
    public function send_invoice_mail($id, $redirect = true) {
        $invoice = Invoice::findOrFail($id);
        $customer = Customers::select('email','first_name','last_name')->where('id',$invoice['Payee']['type_id'])->first();
        $company = CompanySettings::where('id',$this->Company())->first();
        $template = EmailTemplates::select('body')->where('user_id',Auth::user()->id)->where('slug','invoice')->first();
        $company_name = $company['company_name'];
        $from_email = $company['company_email'];
        $customer_email = $customer['email'];
        $company_logo = $company['company_logo'];
        $invoice_number = $invoice['invoice_number'];
        $order_number = $invoice['invoice_number'];
        $customer_name = $customer['first_name'].' '.$customer['last_name'];
        $email_content = $template['body'];
        $email_notification_for_site_admin = $company['email_notification_for_site_admin'];

        $site_admin_email_arr = [];

        if(!empty($email_notification_for_site_admin)) {
            $site_admin_email_arr = explode(',',$email_notification_for_site_admin);
        }

        $data = [
            'company_name' => $company_name,
            'from_name' => $company_name,
            'from_email' => $from_email,
            'customer_email' => $customer_email,
            'invoice_number' => $invoice_number,
            'order_number' => $order_number,
            'customer_name' => $customer_name,
            'company_logo' => $company_logo,
            'email_content' => $email_content,
            'invoice_id' => $id
        ];

        if(count($site_admin_email_arr) > 0) {
            Mail::to($customer_email)->bcc($site_admin_email_arr)->send(new InvoiceMail($data));
        } else {
            Mail::to($customer_email)->send(new InvoiceMail($data));
        }
        if($redirect) {
            return redirect()->back()->with('message','Email has been sent successfully!');
        }
    }
    
    public function send_credit_note_mail($id) {
        $invoice = Invoice::findOrFail($id);
        $customer = Customers::select('email','first_name','last_name')->where('id',$invoice['Payee']['type_id'])->first();
        $company = CompanySettings::where('id',$this->Company())->first();
        $template = EmailTemplates::select('body')->where('user_id',Auth::user()->id)->where('slug','credit-note')->first();
        $company_name = $company['company_name'];
        $from_email = $company['company_email'];
        $customer_email = $customer['email'];
        $company_logo = $company['company_logo'];
        $credit_note_number = $invoice['credit_note_number'];
        $customer_name = $customer['first_name'].' '.$customer['last_name'];
        $email_content = $template['body'];
        $email_notification_for_site_admin = $company['email_notification_for_site_admin'];

        $site_admin_email_arr = [];

        if(!empty($email_notification_for_site_admin)) {
            $site_admin_email_arr = explode(',',$email_notification_for_site_admin);
        }

        $data = [
            'company_name' => $company_name,
            'from_name' => $company_name,
            'from_email' => $from_email,
            'customer_email' => $customer_email,
            'credit_note_number' => $credit_note_number,
            'customer_name' => $customer_name,
            'company_logo' => $company_logo,
            'email_content' => $email_content,
            'credit_note_id' => $id
        ];

        if(count($site_admin_email_arr) > 0) {
            Mail::to($customer_email)->bcc($site_admin_email_arr)->send(new CreditNoteMail($data));
        } else {
            Mail::to($customer_email)->send(new CreditNoteMail($data));
        }
        return redirect()->back()->with('message','Email has been sent successfully!');
    }
}
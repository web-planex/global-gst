<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateBlukCreditNote;
use App\Jobs\GenerateBlukEstimate;
use App\Jobs\GenerateBlukSalesInvoice;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\Estimate;
use App\Models\Globals\EstimateItems;
use App\Models\Globals\Invoice;
use App\Models\Globals\InvoiceItems;
use App\Models\Globals\Job;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\PdfZips;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Taxes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use WKPDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\Globals\EstimateMail;
use App\Models\Globals\EmailTemplates;

class EstimateController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified'], ['except' => 'download_pdf']);
    }

    public function index(Request $request){
        $data['menu'] = 'Estimate';
        $input_search = $request['search'];
        $start_date = !empty($request['start_date'])?date('Y-m-d', strtotime($request['start_date'])) :"";
        $end_date = !empty($request['end_date'])?date('Y-m-d', strtotime($request['end_date'])):"";
        $search = '';
        $query = Estimate::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->select();

        if(isset($input_search) && !empty($input_search)){
            $payee_id = '';

            $payees = Payees::where('name','like','%'.$input_search.'%')->select('id')->get();
            foreach($payees as $pid){
                $payee_id .= $pid['id'].',';
            }

            $query->where(function($q) use($input_search,$payee_id){
                $q->orwhereIn('customer_id', explode(',', $payee_id));
            });
            $search = $input_search;
        }

        if(isset($start_date) && !empty($start_date)){
            $query->where(function($q) use($start_date){
                $q->orwhere('estimate_date','>=',$start_date);
                $q->orwhere('expiry_date','>=',$start_date);
            });
        }

        if(isset($end_date) && !empty($end_date)){
            $query->where(function($q) use($end_date){
                $q->orwhere('estimate_date','<=',$end_date);
                $q->orwhere('expiry_date','<=',$end_date);
            });
        }

        $data['search'] = $search;
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['estimate'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        $data['custom_column'] = [
            'Estimate No',
            'Customer',
            'Estimate Date',
            'Due Date'
        ];
        return view('globals.estimate.index',$data);
    }

    public function create(){
        $user = Auth::user();
        $data['menu'] = 'Estimate';
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
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        return view('globals.estimate.create',$data);
    }

    public function store(Request $request){
        $user = Auth::user();
        $this->validate($request, [
            'customer' => 'required',
            'estimate_date' => 'required',
            'expiry_date' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $estimate = new Estimate();

        $estimate->user_id = $user->id;
        $estimate->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $estimate->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $estimate->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $estimate->tax_type = 3;
        }
        $estimate->customer_id = $request['customer'];
        $estimate->estimate_number = $request['estimate_number'];
        $estimate->estimate_date = date('Y-m-d', strtotime($request['estimate_date']));
        $estimate->expiry_date = date('Y-m-d', strtotime($request['expiry_date']));
        $estimate->amount_before_tax = $request['amount_before_tax'];
        $estimate->tax_amount = $request['tax_amount'];
        $estimate->discount_level = $request['discount_level'];
        $estimate->shipping_charge_amount = $request['shipping_charge_amount'];
        $estimate->shipping_charge = isset($request['shipping_charge'])&&!empty($request['shipping_charge'])?1:0;
        $company = CompanySettings::where('id',$this->Company())->first();

        $total_estimate = Estimate::count();

        if(empty($company['estimate_prefix']) && empty($company['estimate_number'])){
            $estimate->estimate_number = $total_estimate + 1;
            $input['estimate_number'] = $estimate->estimate_number;
            $company->update($input);
        }elseif(!empty($company['estimate_prefix']) && !empty($company['estimate_number'])){
            $estimate->estimate_number = $company['estimate_prefix'].'/'.$company['estimate_number'];
            $input['estimate_number'] = $company['estimate_number'] + 1;
            $company->update($input);
        }elseif(empty($company['estimate_prefix']) && !empty($company['estimate_number'])){
            $estimate->estimate_number = $company['estimate_number'];
            $input['estimate_number'] = $company['estimate_number'] + 1;
            $company->update($input);
        }elseif(!empty($company['estimate_prefix']) && empty($company['estimate_number'])){
            $e_no = $total_estimate + 1;
            $estimate->estimate_number = $company['estimate_prefix'].'/'.$e_no;
            $input['estimate_number'] = $company['estimate_number'] + 1;
            $company->update($input);
        }

        if($request['discount_type'] != '') {
            $estimate->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $estimate->discount = '';
        }
        $estimate->discount_type = $request['discount_type'];
        $estimate->total = $request['total'];

        if($photo = $request->file('files')){
            $estimate->files = $this->allFiles($photo,$user->id.'/estimate/estimate_attachment');
        }

        if($request->has('submit')) {
            $estimate->save();

//            $input['estimate_number'] = $company['estimate_number']+1;
//            $company->update($input);

            $estimate_id = $estimate->id;
            $data = [];
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'estimate_id' => $estimate_id,
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
                EstimateItems::create($data);
            }
            // Send estimate email to customer
            $this->send_estimate_mail($estimate_id, false);
            return redirect('estimate')->with('message','Estimate has been created successfully!');
        }
    }

    public function show($id){
        //
    }

    public function edit($id){
        $user = Auth::user();
        $data['menu'] = 'Estimate';
        $data['estimate'] = Estimate::findOrFail($id);
        $customer = Customers::where('id',$data['estimate']['Payee']['type_id'])->first();
        $billing_state = States::where('id',$customer['billing_state'])->first();
        $shipping_state = States::where('id',$customer['shipping_state'])->first();

        $data['estimate']['customer'] = $customer;
        $data['estimate']['customer']['billing_state_name'] = $billing_state['state_name'];
        $data['estimate']['customer']['shipping_state_name'] = $shipping_state['state_name'];
        $data['estimate']['file_name'] = '';
        if(!empty($data['estimate']['files']) && file_exists($data['estimate']['files'])){
            $ext = explode('/',$data['estimate']['files']);
            $data['estimate']['file_name'] = $ext[4];
            $file_ext = explode('.',$ext[4]);
            $data['estimate']['file_ext'] = $file_ext[1];
        }
        $data['estimate_items'] = EstimateItems::where('estimate_id',$id)->get()->toArray();
        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Customer','')->toArray();
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
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        return view('globals.estimate.create',$data);
    }

    public function update(Request $request, $id){
        $user = Auth::user();
        $this->validate($request, [
            'customer' => 'required',
            'estimate_date' => 'required',
            'expiry_date' => 'required',
            'files' => 'mimes:jpg,png,jpeg,pdf,bmp,xlsx,xls,csv,docx,doc,txt'
        ]);

        $estimate = Estimate::where('id',$id)->first();

        $estimate->user_id = $user->id;
        $estimate->company_id = $this->Company();
        if($request['tax_type'] == 'exclusive') {
            $estimate->tax_type = 1;
        } else if($request['tax_type'] == 'inclusive') {
            $estimate->tax_type = 2;
        } else if($request['tax_type'] == 'out_of_scope') {
            $estimate->tax_type = 3;
        }
        $estimate->customer_id = $request['customer'];
        $estimate->estimate_date = date('Y-m-d', strtotime($request['estimate_date']));
        $estimate->expiry_date = date('Y-m-d', strtotime($request['expiry_date']));
        $estimate->amount_before_tax = $request['amount_before_tax'];
        $estimate->tax_amount = $request['tax_amount'];
        $estimate->discount_level = $request['discount_level'];
        $estimate->shipping_charge_amount = $request['shipping_charge_amount'];
        $estimate->shipping_charge = isset($request['shipping_charge'])&&!empty($request['shipping_charge'])?1:0;
        if($request['discount_type'] != '') {
            $estimate->discount = $request['discount_type']==2?str_replace( ',', '', $request['discount']):str_replace( ' %', '', $request['discount']);
        } else {
            $estimate->discount = '';
        }
        $estimate->discount_type = $request['discount_type'];
        $estimate->total = $request['total'];

        if($photo = $request->file('files')){
            $estimate->files = $this->allFiles($photo,$user->id.'/estimate/estimate_attachment');
        }

        if($request->has('submit')) {
            $estimate->save();
            EstimateItems::where('estimate_id',$estimate['id'])->delete();
            $estimate_id = $estimate->id;
            $data = [];
            for($i=0;$i<count($request['product']);$i++) {
                $data = [
                    'estimate_id' => $estimate_id,
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
                EstimateItems::create($data);
            }
            return redirect('estimate')->with('message','Estimate has been updated successfully!');
        }
    }

    public function destroy($id){
        $estimate = Estimate::where('id',$id)->first();
        if(!empty($estimate['files']) && file_exists($estimate['files'])){
            unlink($estimate['files']);
        }
        $estimate->delete();
        \Session::flash('error-message', 'Estimate has been deleted successfully!');
        return redirect()->back();
    }

    public function delete_attachment(Request $request){
        $estimate = Estimate::where('id',$request['data'])->first();
        if(!empty($estimate['files']) && file_exists($estimate['files'])){
            unlink($estimate['files']);
        }
        $input['files'] = null;
        $estimate->update($input);
        return ;
    }

    public function download_pdf(Request $request, $id){
        $data['estimate'] = Estimate::with('EstimateItems')->where('id',$id)->first();
        $user_id = $data['estimate']['user_id'];
        $company_id = $data['estimate']['company_id'];
        $data['estimate_type'] = 'Estimate';
        $data['menu']  = 'Estimate';
        $data['print_type']  = isset($request['type'])&&$request['type']=='credit_note'?2:1;
        $data['company'] = CompanySettings::where('id',$company_id)->first();
        $state = States::where('id',$data['company']['state'])->first();
        $data['company']['state'] = $state['state_name'];
        $data['company']['state_code'] = $state['state_number'];
        

        /*Count Discount Price*/
        if($data['estimate']['discount_type']==1){
            $main_total = $data['estimate']['amount_before_tax'] + $data['estimate']['tax_amount'];
            $discount = ($main_total / 100) * $data['estimate']['discount'];
            $data['estimate']['discount_price'] = number_format($discount,2);
        }else{
            $data['estimate']['discount_price'] = $data['estimate']['discount'];
        }
        $data['taxes'] = Taxes::where('status', 1)->get();
        $tax_count = 5;
        foreach($data['taxes'] as $tax) {
            $tax['tax_name'] == 'GST' ? $tax_count += 2 : $tax_count += 1;
        }
        $data['tax_count'] = $tax_count;

        if(!empty($data['estimate']['EstimateItems'])){
            foreach($data['estimate']['EstimateItems'] as $item){
                $tax = Taxes::where('id',$item['tax_id'])->first();
                if($tax['is_cess'] == 0) {
                    $item['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                } else {
                    $item['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                }
            }
        }
        $data['estimate']['total_in_word'] = $this->convert_digit_to_words($data['estimate']['total']);

        $payee = Payees::where('id',$data['estimate']['customer_id'])->first();
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
        $data['name']  = 'Estimate';
        $data['content'] = 'This is test pdf.';
        $pdf = new WKPDF($this->globalPdfOption());
        $pdf->addPage(view('globals.estimate.pdf_estimate',$data));
        if($request->output == 'download') {
            if (!$pdf->send('estimate.pdf')) {
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
        $checkboxes = $request['all_estimate_check'];
        $download_type = $request['download_type'];
        $estimate_type = $request['invoice_type'];
        $job = (new GenerateBlukEstimate($user,$company_id,$checkboxes,$download_type,$estimate_type))->onQueue('multiple_estimate_invoice_pdf');
        dispatch($job);
        return redirect('download-estimate-pdf-zip');
    }

    public function downloadPdfZip() {
        date_default_timezone_set('Asia/Kolkata');
        $user = Auth::user();
        $company_id = $this->Company();
        $company = CompanySettings::where('id',$company_id)->first();
        $job_id = $company['job_id'];
        $pdfZip = PdfZips::where('user_id',$user->id)->where('company_id',$company_id)->where('zip_type',4)->orderBy('id','DESC')->get();
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
            'menu' => 'Estimate',
            'user_id' => $user->id,
            'zip_files' => $pdfZip,
            'job_status' => $job_status
        ];
        return view('globals.estimate.get_pdf_zip',$data);
    }

    public function get_address(Request $request){
        $payee = Payees::where('id',$request['data'])->first();
        $customer = Customers::where('id',$payee['type_id'])->first();
        $address = '';
        $billing_state = States::where('id',$customer['billing_state'])->first();
        $shipping_state = States::where('id',$customer['shipping_state'])->first();
        $billing_address = [$customer['billing_name'],$customer['billing_phone'],$customer['billing_street'],$customer['billing_city'],$customer['billing_state'],$customer['billing_pincode']];
        $shipping_address = [$customer['shipping_name'],$customer['shipping_phone'],$customer['shipping_street'],$customer['shipping_city'],$customer['shipping_state'],$customer['shipping_pincode']];
        $address .= '<div class="col-md-6">
                        <div class="card border-info mb-0" style="background-color: #f5f5f5;">
                            <div class="card-header bg-primary">
                                <h4 class="m-b-0 text-white pull-left">Billing Address</h4>
                                <a href="javascript:;" data-toggle="modal" data-target="#BillingAddressModal">
                                    <h4 class="m-b-0 text-white text-right">Change</h4>
                                </a>    
                            </div>
                            <div class="card-body pt-2 pb-2">
                                <div id="BillingDiv">
                                    <p class="card-text mb-0">'.$customer['billing_name'].'</p>
                                    <p class="card-text mb-0">'.$customer['billing_phone'].'</p>
                                    <p class="card-text mb-0">'.$customer['billing_street'].'</p>
                                    <p class="card-text mb-0">'.$customer['billing_city'].' - '.$customer['billing_pincode'].'</p>
                                    <p class="card-text mb-0">'.$billing_state['state_name'].'</p>
                                    <p class="card-text mb-0">'.$customer['billing_country'].'</p>
                                </div>
                                <div id="billing_msg" class="text-info font-weight-bolder"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-info mb-0" style="background-color: #f5f5f5;">
                            <div class="card-header bg-primary">
                                <h4 class="m-b-0 text-white pull-left">Shipping Address</h4>
                                <a href="javascript:;" data-toggle="modal" data-target="#ShippingAddressModal">
                                    <h4 class="m-b-0 text-white text-right">Change</h4>
                                </a>    
                            </div>
                            <div class="card-body pt-2 pb-2">
                                <div id="ShippingDiv">
                                    <p class="card-text mb-0">'.$customer['shipping_name'].'</p>
                                    <p class="card-text mb-0">'.$customer['shipping_phone'].'</p>
                                    <p class="card-text mb-0">'.$customer['shipping_street'].'</p>
                                    <p class="card-text mb-0">'.$customer['shipping_city'].' - '.$customer['shipping_pincode'].'</p>
                                    <p class="card-text mb-0">'.$shipping_state['state_name'].'</p>
                                    <p class="card-text mb-0">'.$customer['shipping_country'].'</p>
                                </div>
                                <div id="shipping_msg" class="text-info font-weight-bolder"></div>    
                            </div>
                        </div>
                    </div>';


        $data['address'] = $address;
        $data['billing_address'] = $billing_address;
        $data['shipping_address'] = $shipping_address;
        $data['customer_id'] = $customer['id'];

        return $data;
    }

    public function update_billing_address(Request $request){
        $payee = Payees::where('id',$request['customer_id'])->first();
        $customer = Customers::where('id',$payee['type_id'])->first();
        $input = $request->all();
        $customer->update($input);

        $state = States::where('id',$customer['billing_state'])->first();

        $address ='<p class="card-text mb-0">'.$customer['billing_name'].'</p>
                    <p class="card-text mb-0">'.$customer['billing_phone'].'</p>
                    <p class="card-text mb-0">'.$customer['billing_street'].'</p>
                    <p class="card-text mb-0">'.$customer['billing_city'].' - '.$customer['billing_pincode'].'</p>
                    <p class="card-text mb-0">'.$state['state_name'].'</p>
                    <p class="card-text mb-0">'.$customer['billing_country'].'</p>';

        return $address;
    }

    public function update_shipping_address(Request $request){
        $payee = Payees::where('id',$request['customer_id'])->first();
        $customer = Customers::where('id',$payee['type_id'])->first();
        $input = $request->all();
        $customer->update($input);

        $state = States::where('id',$customer['shipping_state'])->first();

        $address ='<p class="card-text mb-0">'.$customer['shipping_name'].'</p>
                    <p class="card-text mb-0">'.$customer['shipping_phone'].'</p>
                    <p class="card-text mb-0">'.$customer['shipping_street'].'</p>
                    <p class="card-text mb-0">'.$customer['shipping_city'].' - '.$customer['shipping_pincode'].'</p>
                    <p class="card-text mb-0">'.$state['state_name'].'</p>
                    <p class="card-text mb-0">'.$customer['shipping_country'].'</p>';

        return $address;
    }

    public function convert_to_invoice(Request $request){
        $estimate = Estimate::where('id',$request['estimate_id'])->first();
        if(!empty($estimate)){
            $input['user_id'] = $estimate['user_id'];
            $input['company_id'] = $estimate['company_id'];
            
            $company = CompanySettings::where('id',$this->Company())->first();
            $total_invoice = Invoice::count();

            if(empty($company['invoice_prefix']) && empty($company['invoice_number'])){
                $input['invoice_number'] = $total_invoice + 1;
                $input1['invoice_number'] = $input['invoice_number'];
                $company->update($input1);
            }elseif(!empty($company['invoice_prefix']) && !empty($company['invoice_number'])){
                $input['invoice_number'] = $company['invoice_prefix'].'/'.$company['invoice_number'];
                $input1['invoice_number'] = $company['invoice_number'] + 1;
                $company->update($input1);
            }elseif(empty($company['invoice_prefix']) && !empty($company['invoice_number'])){
                $input['invoice_number'] = $company['invoice_number'];
                $input1['invoice_number'] = $company['invoice_number'] + 1;
                $company->update($input1);
            }elseif(!empty($company['invoice_prefix']) && empty($company['invoice_number'])){
                $in_no = $total_invoice + 1;
                $input['invoice_number'] = $company['invoice_prefix'].'/'.$in_no;
                $input1['invoice_number'] = $company['invoice_number'] + 1;
                $company->update($input1);
            }
            
            $input['order_number'] = null;
            $input['reference_number'] = null;
            $input['credit_note_number'] = null;
            $input['tax_type'] = $estimate['tax_type'];
            $input['customer_id'] = $estimate['customer_id'];
            $input['invoice_date'] = Carbon::now()->format('Y-m-d');
            $input['due_date'] = Carbon::now()->format('Y-m-d');
            $input['void_date'] = null;
            $input['payment_date'] = null;
            $input['place_of_supply'] = null;
            $input['amount_before_tax'] = $estimate['amount_before_tax'];
            $input['tax_amount'] = $estimate['tax_amount'];
            $input['discount'] = $estimate['discount'];
            $input['discount_level'] = $estimate['discount_level'];
            $input['discount_type'] = $estimate['discount_type'];
            $input['total'] = $estimate['total'];
            $input['files'] = $estimate['files'];
            $input['shipping_charge'] = $estimate['shipping_charge'];
            $input['shipping_charge_amount'] = $estimate['shipping_charge_amount'];
            $input['payment_method'] = null;
            $input['payment_terms'] = null;
            $input['notes'] = null;
            $input['status'] = 1;

            $invoice = Invoice::create($input);

            //Estimate Items -> Invoice Items
            $estimateItems = EstimateItems::where('estimate_id',$request['estimate_id'])->get();

            if(!empty($estimateItems)){
                foreach ($estimateItems as $item){
                    $in['invoice_id'] = $invoice['id'];
                    $in['product_id'] = $item['product_id'];
                    $in['hsn_code'] = $item['hsn_code'];
                    $in['quantity'] = $item['quantity'];
                    $in['rate'] = $item['rate'];
                    $in['amount'] = $item['amount'];
                    $in['tax_id'] = $item['tax_id'];
                    $in['discount'] = $item['discount'];
                    $in['discount_type'] = $item['discount_type'];
                    InvoiceItems::create($in);
                }
            }
            $estimate->delete();
        }
        return ;
    }
    
    public function send_estimate_mail($id, $redirect = true) {
        $estimate = Estimate::findOrFail($id);
        $customer = Customers::select('email','first_name','last_name')->where('id',$estimate['Payee']['type_id'])->first();
        $company = CompanySettings::where('id',$this->Company())->first();
        $template = EmailTemplates::select('body')->where('user_id',Auth::user()->id)->where('slug','estimate')->first();
        $company_name = $company['company_name'];
        $from_email = $company['company_email'];
        $customer_email = $customer['email'];
        $company_logo = $company['company_logo'];
        $estimate_number = $estimate['estimate_number'];
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
            'estimate_number' => $estimate_number,
            'customer_name' => $customer_name,
            'company_logo' => $company_logo,
            'email_content' => $email_content,
            'estimate_id' => $id
        ];

        if(count($site_admin_email_arr) > 0) {
            Mail::to($customer_email)->bcc($site_admin_email_arr)->send(new EstimateMail($data));
        } else {
            Mail::to($customer_email)->send(new EstimateMail($data));
        }
        if($redirect) {
            return redirect()->back()->with('message','Email has been sent successfully!');
        }
    }
}
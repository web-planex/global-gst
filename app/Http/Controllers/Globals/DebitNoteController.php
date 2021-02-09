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

class DebitNoteController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified'], ['except' => 'download_pdf']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'Notes',
            'Status'
        ];
        return view('globals.debit-note.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $data['payees'] = payees::where('user_id',$user->id)->where('company_id',$this->Company())->where('type',3)->pluck('name','id')->prepend('Select Customer','')->toArray();
        $data['payment_method'] = PaymentMethod::where('user_id',$user->id)->pluck('method_name', 'id')->toArray();
        $data['products'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->get();
        $data['first_product'] = Product::where('user_id',$user->id)->where('company_id',$this->Company())->where('status',1)->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        $data['payment_terms'] = PaymentTerms::all();
        $data['address_states'] = States::orderBy('state_name','ASC')->select('state_name','id')->get();
        $data['invoice_ids'] = Invoice::where('user_id',$user->id)->where('company_id',$this->Company())->pluck('invoice_number','id')->toArray();
        return view('globals.debit-note.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

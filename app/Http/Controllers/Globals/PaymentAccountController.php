<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Globals\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Taxes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Request;

class PaymentAccountController extends Controller
{
    public function __construct(){

        $this->middleware('UserAccessRight');
    }

    public function index(){
        $input_search = Request::input('search');
        $start_date = !empty(Request::input('start_date'))?date('Y-m-d', strtotime(Request::input('start_date'))) :"";
        $end_date =  !empty(Request::input('end_date'))?date('Y-m-d', strtotime(Request::input('end_date'))):"";
        
        $data['menu'] = 'payment-account';
        $query = PaymentAccount::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->select();
         $search = '';
        if(isset($input_search) && !empty($input_search)){
             $atypes = '';
             $cassets = '';
             $tid = '';
             
             foreach (PaymentAccount::$account_type as $key => $type){
                 if(preg_grep('~'. strtolower($input_search).'~', array(strtolower($type)))){
                     $atypes .= $key.',';
                 }
             }
             
             foreach (PaymentAccount::$current_assets as $key1 => $type1){
                 if(preg_grep('~'. strtolower($input_search).'~', array(strtolower($type1)))){
                     $cassets .= $key1.',';
                 }
             }
             
             foreach (PaymentAccount::$bank as $key2 => $type2){
                 if(preg_grep('~'. strtolower($input_search).'~', array(strtolower($type2)))){
                     $cassets .= $key2.',';
                 }
             }
             
             $tax_ids = Taxes::where('tax_name',$input_search)->select('id')->get();
             foreach ($tax_ids as $ids){
                 $tid .= $ids['id'].',';
             }
             
             $query->where(function($q) use($input_search, $atypes, $cassets,  $tid){
                        $q->orwhere('name','like','%'.$input_search.'%');
                        $q->orwhereIn('account_type', explode(',', $atypes));
                        $q->orwhereIn('detail_type', explode(',', $cassets));
                        $q->orwhereIn('default_tax_code', explode(',', $tid));
                        $q->orwhere('balance', str_replace(',', '', $input_search));
              });
             $search = $input_search;
        }
        
        if(isset($start_date) && !empty($start_date)){
            $query->where('as_of','>=',$start_date);
        }
        
        if(isset($end_date) && !empty($end_date)){
            $query->where('as_of','<=',$end_date);
        }
        
        $data['search'] = $search;
        $data['start_date'] =Request::input('start_date');
        $data['end_date'] = Request::input('end_date');
        $data['payment_accounts'] = $query->orderBy('id','DESC')->paginate($this->pagination);
        return view('globals.payment-account.index', $data);
    }

    public function create(){
        $data['menu'] = 'payment-account';
        $data['taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
        return view('globals.payment-account.create', $data);
    }

    public function edit($id){
        $data['menu'] = 'payment-account';
        $data['payment_account'] = PaymentAccount::findOrFail($id);
        $data['taxes'] = Taxes::where('status', 1)->pluck('tax_name', 'id')->toArray();
        return view('globals.payment-account.create', $data);
    }

    public function addedit($id = '') {
        $message = '';
        $validator = Validator::make(Request::all(), [
            'account_type' => 'required',
            'detail_type' => 'required',
            'name' => 'required',
            'balance' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (trim($id) == '') {
            $payment_account = new PaymentAccount();
            $message = 'Payment Account has been created successfully!';
        } else {
            $payment_account = PaymentAccount::findOrFail($id);
            $message = 'Payment Account has been updated successfully!';
        }

        if (Request::has('submit')) {
            $payment_account->user_id = Auth::user()->id;
            $payment_account->company_id = $this->Company();
            $payment_account->account_type = Request::input('account_type');
            $payment_account->detail_type = Request::input('detail_type');
            $payment_account->name = Request::input('name');
            $payment_account->description = Request::input('description');
            $payment_account->default_tax_code = Request::input('default_tax_code');
            $payment_account->balance = Request::input('balance');
            $payment_account->as_of = date("Y-m-d", strtotime(Request::input('as_of')));
            $payment_account->save();
            return redirect()->route('payment-account')->with('message', $message);
        }
    }

    public function ajaxGetAccountType() {
        $name = strtolower(str_replace(' ', '_', Request::input('name')));
        $get_name = PaymentAccount::${$name};
        return response()->json(['response'=>$get_name]);
    }

    public function delete($id){
        $payment_account = PaymentAccount::where('id',$id)->first();
        $payment_account->delete();
        \Session::flash('error-message', 'Payment Account has been deleted successfully!');
        return redirect('payment-account');
    }
}

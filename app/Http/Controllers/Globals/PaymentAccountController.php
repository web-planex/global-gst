<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Taxes;
use Illuminate\Support\Facades\Validator;
use Request;

class PaymentAccountController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['menu'] = 'payment-account';
        $data['payment_accounts'] = PaymentAccount::orderBy('id','DESC')->get();
        return view('globals.payment-account.index', $data);
    }

    public function create(){
        $data['menu'] = 'payment-account';
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

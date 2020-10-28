<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\PaymentAccount;
use App\Models\Globals\Taxes;
use Illuminate\Http\Request;

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
        $data['taxes'] = Taxes::where('status',1)->get();
        return view('globals.payment-account.create', $data);
    }
}

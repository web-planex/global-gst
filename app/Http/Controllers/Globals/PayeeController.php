<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Payees;
use Illuminate\Http\Request;

class PayeeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['payees'] = Payees::orderBy('id','DESC')->get();
        return view('payees.index',$data);
    }

    public function create(){
        return view('payees.create');
    }
}

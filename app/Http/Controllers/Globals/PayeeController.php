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
        $data['menu'] = 'Payees';
        $data['payees'] = Payees::orderBy('id','DESC')->get();
        return view('globals.payees.index',$data);
    }

    public function create(){
        $data['menu'] = 'Payees';
        return view('globals.payees.create',$data);
    }

    public function store(Request  $request){
        return 'in';
//        if($request['type']==1){
//            $this->validate($request, [
//                'first_name' => 'required',
//                'last_name' => 'required',
//                'email' => 'required',
//                'mobile' => 'required',
//                'displayname' => 'required',
//                'street' => 'required',
//                'city' => 'required',
//                'state' => 'required',
//                'pincode' => 'required',
//                'country' => 'required',
//            ]);
//        }
    }
}

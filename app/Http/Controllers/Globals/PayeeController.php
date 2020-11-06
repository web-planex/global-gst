<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Payees;
use App\Models\Globals\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayeeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['menu'] = 'Payees';
        $data['payees'] = Payees::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate($this->pagination);
        return view('globals.payees.index',$data);
    }

    public function create(){
        $data['menu'] = 'Payees';
        return view('globals.payees.create',$data);
    }

    public function store(Request  $request){
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        $payee['user_id'] = $user->id;
        if($request['type']==1){
            $input['apply_tds_for_supplier'] = isset($request['apply_tds_for_supplier'])&&!empty($request['apply_tds_for_supplier'])?1:0;
            $supplier = Suppliers::create($input);

            $payee['name'] = $supplier['first_name'].' '.$supplier['last_name'];
            $payee['type'] = 1;
            $payee['type_id'] = $supplier['id'];
        }elseif ($request['type']==2){
            $input['hire_date'] = !empty($request['hire_date'])?date('y-m-d',strtotime($request['hire_date'])):"";
            if(!empty($request['released'])){
                $input['released'] = date('y-m-d',strtotime($request['released']));
            }
            if(!empty($request['date_of_birth'])){
                $input['date_of_birth'] = date('y-m-d',strtotime($request['date_of_birth']));
            }
            $employee = Employees::create($input);

            $payee['name'] = $employee['first_name'].' '.$employee['last_name'];
            $payee['type'] = 2;
            $payee['type_id'] = $employee['id'];
        }else{
            $customer = Customers::create($input);

            $payee['name'] = $customer['first_name'].' '.$customer['last_name'];
            $payee['type'] = 3;
            $payee['type_id'] = $customer['id'];
        }
        Payees::create($payee);
        \Session::flash('message', 'Payee has been created successfully!');
        return redirect('payees');
    }

    public function edit($id){
        $data['menu'] = 'Payees';
        $data['payee'] = Payees::findOrFail($id);
        if($data['payee']['type']==1){
            $data['user'] = Suppliers::where('id',$data['payee']['type_id'])->first();
        }elseif($data['payee']['type']==2){
            $data['user'] = Employees::where('id',$data['payee']['type_id'])->first();
        }else{
            $data['user'] = Customers::where('id',$data['payee']['type_id'])->first();
        }
        return view('globals.payees.create',$data);
    }

    public function update(Request $request,$id){
        $input = $request->all();
        $payees = Payees::where('id',$id)->first();
        if($request['type']==1){
            $input['apply_tds_for_supplier'] = isset($request['apply_tds_for_supplier'])&&!empty($request['apply_tds_for_supplier'])?1:0;
            $supplier = Suppliers::where('id',$payees['type_id'])->first();
            $supplier->update($input);

            $payee['name'] = $supplier['first_name'].' '.$supplier['last_name'];
        }elseif ($request['type']==2){
            $input['hire_date'] = !empty($request['hire_date'])?date('y-m-d',strtotime($request['hire_date'])):"";
            if(!empty($request['released'])){
                $input['released'] = date('y-m-d',strtotime($request['released']));
            }
            if(!empty($request['date_of_birth'])){
                $input['date_of_birth'] = date('y-m-d',strtotime($request['date_of_birth']));
            }
            $employees = Employees::where('id',$payees['type_id'])->first();
            $employees->update($input);

            $payee['name'] = $employees['first_name'].' '.$employees['last_name'];
        }else{
            $customer = Customers::where('id',$payees['type_id'])->first();
            $customer->update($input);

            $payee['name'] = $customer['first_name'].' '.$customer['last_name'];
        }
        $payees->update($payee);
        \Session::flash('message', 'Payee has been updated successfully!');
        return redirect('payees');
    }

    public function delete($id){
        $payee = Payees::where('id',$id)->first();
        if($payee['type']==1){
            $user = Suppliers::where('id',$payee['type_id'])->first();
        }elseif($payee['type']==2){
            $user = Employees::where('id',$payee['type_id'])->first();
        }else{
            $user = Customers::where('id',$payee['type_id'])->first();
        }
        if(!empty($user)){
            $user->delete();
        }
        $payee->delete();
        \Session::flash('error-message', 'Payee has been deleted successfully!');
        return redirect('payees');
    }
}

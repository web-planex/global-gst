<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Payees;
use App\Models\Globals\Suppliers;
use Illuminate\Http\Request;

class PayeeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['menu'] = 'Payees';
        $data['payees'] = Payees::orderBy('id','DESC')->paginate($this->pagination);
        return view('globals.payees.index',$data);
    }

    public function create(){
        $data['menu'] = 'Payees';
        return view('globals.payees.create',$data);
    }

    public function store(Request  $request){
        $input = $request->all();
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

    public function delete($id){
        $payee = Payees::where('id',$id)->first();
        $payee->delete();
        \Session::flash('error-message', 'Payee has been deleted successfully!');
        return redirect('payees');
    }
}

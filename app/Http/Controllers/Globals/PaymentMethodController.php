<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
    }

    public function index(Request $request){
        $user = Auth::user()->id;
        $data['menu'] = 'Payment Methods';
        $search = '';
        $query = PaymentMethod::where('user_id',$user)->select();
        if(isset($request['search']) && !empty($request['search'])){
            $query->where(function ($q) use($request){
                $q->orwhere('method_name','like','%'.$request['search'].'%');
            });
            $search = $request['search'];
        }
        $data['search'] = $search;
        $data['payment_method'] = $query->Paginate($this->pagination);
        return view('globals.payment_method.index',$data);
    }

    public function create(){
        $data['menu'] = 'Payment Methods';
        return view('globals.payment_method.create',$data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'method_name' => 'required',
        ]);
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        
        PaymentMethod::create($input);
        \Session::flash('message', 'Payment method has been inserted successfully!');
        return redirect('payment-methods');
    }

    public function show($id){
        //
    }

    public function edit($id){
        $data['menu'] = 'Payment Methods';
        $data['payment_method'] = PaymentMethod::findOrFail($id);
        return view('globals.payment_method.create',$data);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'method_name' => 'required',
        ]);
        $payment_method = PaymentMethod::where('id',$id)->first();
        $input = $request->all();
        $payment_method->update($input);
        \Session::flash('message', 'Payment method has been updated successfully!');
        return redirect('payment-methods');
    }

    public function destroy($id){
        $payment_method = PaymentMethod::where('id',$id)->first();
        $payment_method->delete();
        \Session::flash('error-message', 'Payment method has been deleted successfully!');
        return redirect('payment-methods');
    }
}

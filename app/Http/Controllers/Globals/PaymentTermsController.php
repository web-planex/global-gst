<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\PaymentTerms;
use App\Models\Globals\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentTermsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
    }

    public function index(Request $request){
        $user = Auth::user()->id;
        $data['menu'] = 'Payment Terms';
        $search = '';
        $query = PaymentTerms::where('user_id',$user)->where('company_id',$this->Company())->select();
        if(isset($request['search']) && !empty($request['search'])){
            $query->where(function ($q) use($request){
                $q->orwhere('terms_name','like','%'.$request['search'].'%');
                $q->orwhere('terms_days',$request['search']);
            });
            $search = $request['search'];
        }
        $data['search'] = $search;
        $data['payment_terms'] = $query->Paginate($this->pagination);
        return view('globals.payment_terms.index',$data);
    }

    public function create(){
        $data['menu'] = 'Payment Terms';
        return view('globals.payment_terms.create',$data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'terms_name' => 'required',
            'terms_days' => 'required',
        ]);
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();

        PaymentTerms::create($input);
        \Session::flash('message', 'Payment terms has been inserted successfully!');
        return redirect('payment-terms');
    }

    public function show($id){
        //
    }

    public function edit($id){
        $data['menu'] = 'Payment Terms';
        $data['payment_terms'] = PaymentTerms::findOrFail($id);
        return view('globals.payment_terms.create',$data);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'terms_name' => 'required',
            'terms_days' => 'required',
        ]);
        $payment_terms = PaymentTerms::where('id',$id)->first();
        $input = $request->all();
        $payment_terms->update($input);
        \Session::flash('message', 'Payment terms has been updated successfully!');
        return redirect('payment-terms');
    }

    public function destroy($id){
        $payment_terms = PaymentTerms::where('id',$id)->first();
        $payment_terms->delete();
        \Session::flash('error-message', 'Payment terms has been deleted successfully!');
        return redirect('payment-terms');
    }
}
<?php

namespace App\Http\Controllers\Globals;

use App\CompanySettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $data['menu'] = 'Company';
        return view('globals.company.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_logo' => 'mimes:jpg,jpeg,png,bmp',
            'company_name' => 'required',
            'pan_no' => 'required',
            'gstin' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'country' => 'required',
        ]);
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        if($photo = $request->file('company_logo')){
            $input['company_logo'] = $this->image($photo,$user->id.'/company');
        }
        CompanySettings::create($input);
        \Session::flash('message', 'Company has been inserted successfully!');
        return redirect('companies/'.$user->id);
    }

    public function show($id)
    {
        $user = Auth::user()->id;
        if($id != $user){
            \Session::flash('error-message', "You have not permission for access other user's companies!");
            return redirect('companies/'.$user);
        }
        $data['menu'] = 'Company';
        $data['companies'] = CompanySettings::where('user_id',$id)->Paginate($this->pagination);
        return view('globals.company.index',$data);
    }

    public function edit($id)
    {
        $data['menu'] = 'Company';
        $data['companies'] = CompanySettings::findOrFail($id);
        return view('globals.company.create',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_logo' => 'mimes:jpg,jpeg,png,bmp',
            'company_name' => 'required',
            'pan_no' => 'required',
            'gstin' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'country' => 'required',
        ]);
        $companies = CompanySettings::where('id',$id)->first();
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;
        if($photo = $request->file('company_logo')){
            $input['company_logo'] = $this->image($photo,$user->id.'/company');
        }
        $companies->update($input);
        \Session::flash('message', 'Company has been updated successfully!');
        return redirect('companies/'.$user->id);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $company = CompanySettings::where('id',$id)->first();
        $company->delete();
        \Session::flash('error-message', 'Company has been deleted successfully!');
        return redirect('companies/'.$user->id);
    }
}

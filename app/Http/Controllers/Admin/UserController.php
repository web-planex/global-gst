<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Globals\CompanySettings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('multiauth:admin');
    }

    public function index(Request $request){
        $data['menu'] = 'Users';
        $query = User::where('role','user')->select();
        if(isset($request['search']) && !empty($request['search'])){
            $query->where(function($q) use($request){
                $q->orwhere('name','like','%'.$request['search'].'%');
                $q->orwhere('email','like','%'.$request['search'].'%');
                $q->orwhere('mobile','like','%'.$request['search'].'%');
            });
        }
        $data['search'] = $request['search'];
        $data['users'] = $query->paginate($this->pagination);
        return view('admin.users.index',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $user = User::where('id',$id)->first();
        $user->delete();
        \Session::flash('error-message', 'User has been deleted successfully!');
        return redirect('admin/users');
    }

    public function edit_profile(){
        $user = Auth::guard('admin')->user();
        $data['menu'] = 'Profile';
        $data['user'] = User::where('id',$user['id'])->first();
        $data['company'] = CompanySettings::where('id',$this->Company())->first();
        return view('admin.users.edit_profile',$data);
    }

    public function update_profile(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if(empty($request['password'])){
            unset($request['password']);
        }
        $input = $request->all();
        $input['password'] = Hash::make($request['password']);
        $user = User::where('id',$id)->first();
        $user->update($input);
        \Session::flash('message', 'Profile has been updated successfully!');
        return redirect()->back();
    }

    public function user_login(Request $request){
        if(Auth::guard('admin')->check()){

            Auth::guard('web')->logout();
            $request->session()->forget('company_selection');
            $request->session()->forget('company');

            $user = User::where('id',$request['user_id'])->first();
            Auth::guard('web')->login($user);

            $company_count = CompanySettings::where('user_id',$user['id'])->get()->count();
            if($company_count > 1) {
                $session_company_selection = Session::get('company_selection');
                if(empty($session_company_selection)) {
                    session(['company_selection' => true]);
                }
            } else {
                $session = Session::get('company');
                if(empty($session)){
                    $company = CompanySettings::where('user_id',$user['id'])->orderBy('id','DESC')->first();
                    if(!empty($company)){
                        session(['company'=>$company['id']]);
                    }
                }
            }
            return ;
        }
    }
}
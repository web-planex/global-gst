<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Globals\CompanySettings;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','verified']);
        $this->middleware('AdminAccessRight');
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

    public function edit_profile($id){
        $data['menu'] = 'Profile';
        $data['user'] = User::where('id',$id)->first();
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
        $user = User::where('id',$id)->first();
        $user->update($input);
        \Session::flash('message', 'Profile has been updated successfully!');
        return redirect()->back();
    }
}

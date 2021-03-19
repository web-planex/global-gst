<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Globals\EmailTemplates;
use Illuminate\Support\Facades\Auth;

class EmailTemplatesController extends Controller
{
    public function __construct(){
        $this->middleware('multiauth:web');
//        $this->middleware('UserAccessRight');
    }

    public function show($slug) {
        $data['template'] = EmailTemplates::where('user_id',Auth::user()->id)->where('slug',$slug)->firstOrFail();
        $data['menu'] = 'EmailTemplate'.$slug;
        $data['slug'] = $slug;
        return view('globals.email-template.template',$data);
    }
    
    public function update(Request $request, $slug) {
        $this->validate($request, ['body' => 'required']);
        $template = EmailTemplates::where('user_id',Auth::user()->id)->where('slug',$slug)->first();
        $template->body = $request['body'];
        $template->save();
        return redirect()->back()->with('message','Email template has been updated successfully!');
    }
}

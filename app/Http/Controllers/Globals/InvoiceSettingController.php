<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\InvoiceSetting;
use App\Models\Globals\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class InvoiceSettingController extends Controller
{
    public function __construct(){

        $this->middleware('UserAccessRight');
    }

    public function index(){
        $data['menu'] = 'Company Setting';
        $data['invoice_setting'] = CompanySettings::where('user_id',Auth::user()->id)->where('id',$this->Company())->first();
        $data['states'] = States::orderBy('state_name','ASC')->pluck('state_name','id');
        return view('globals.invoice-setting.form',$data);
    }

    public function store(Request  $request){
        $this->validate($request, [
            'company_logo' => 'mimes:jpeg,jpg,bmp,png',
            'signature_image' => 'mimes:png',
            'store_phone' => 'nullable|numeric',
            'store_email' => 'nullable|email',
            'invoice_number' => 'nullable|numeric',
            'credit_note_number' => 'nullable|numeric',
        ]);

        $user = Auth::user();
        $invoice_setting = CompanySettings::where('user_id',$user->id)->where('id',$this->Company())->first();
        $input = $request->all();
        $input['user_id'] = $user->id;
        $input['product_price_gst'] = isset($request['product_price_gst'])&&!empty($request['product_price_gst'])?1:0;
        $input['shipping_price_gst'] = isset($request['shipping_price_gst'])&&!empty($request['shipping_price_gst'])?1:0;
        $input['shipping_gst'] = isset($request['shipping_gst'])&&!empty($request['shipping_gst'])?1:0;
        $input['igst_on_export_order'] = isset($request['igst_on_export_order'])&&!empty($request['igst_on_export_order'])?1:0;

        if($photo = $request->file('company_logo')){
            $detail = getimagesize($request['company_logo']);
            if($detail[0] > 100 && $detail[1] > 100){
                    throw ValidationException::withMessages([
                    'company_logo' => [trans('The logo image file has invalid image dimensions.')],
                ]);
            }else{
                $input['company_logo'] = $this->image($photo,$user->id.'/company');
            }
        }
        if($photo2 = $request->file('signature_image')){
            $detail2 = getimagesize($request['signature_image']);
            if($detail2[0] > 150 && $detail2[1] > 80){
                throw ValidationException::withMessages([
                    'signature_image' => [trans('The signature image file has invalid image dimensions.')],
                ]);
            }else{
                $input['signature_image'] = $this->image($photo2,$user->id.'/company');
            }
        }

        if(!empty($invoice_setting)){
            $invoice_setting->update($input);
        }else{
            CompanySettings::create($input);
        }
        \Session::flash('message', 'Company setting has been updated successfully!');
        return redirect('company-setting');
    }
}

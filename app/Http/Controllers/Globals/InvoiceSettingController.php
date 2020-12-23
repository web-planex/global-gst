<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\InvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class InvoiceSettingController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['menu'] = 'Invoice Setting';
        $data['invoice_setting'] = InvoiceSetting::where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
        return view('globals.invoice-setting.form',$data);
    }

    public function store(Request  $request){
        $this->validate($request, [
            'logo_image' => 'mimes:jpeg,jpg,bmp,png',
            'signature_image' => 'mimes:png',
            'store_phone' => 'nullable|numeric',
            'store_email' => 'nullable|email',
            'invoice_number' => 'nullable|numeric',
            'credit_note_number' => 'nullable|numeric',
        ]);

        $user = Auth::user();
        $invoice_setting = InvoiceSetting::where('user_id',$user->id)->first();
        $input = $request->all();
        $input['user_id'] = $user->id;
        $input['company_id'] = $this->Company();
        $input['product_price_gst'] = isset($request['product_price_gst'])&&!empty($request['product_price_gst'])?1:0;
        $input['shipping_price_gst'] = isset($request['shipping_price_gst'])&&!empty($request['shipping_price_gst'])?1:0;
        $input['shipping_gst'] = isset($request['shipping_gst'])&&!empty($request['shipping_gst'])?1:0;
        $input['igst_on_export_order'] = isset($request['igst_on_export_order'])&&!empty($request['igst_on_export_order'])?1:0;

        if($photo = $request->file('logo_image')){
            $detail = getimagesize($request['logo_image']);
            if($detail[0] > 100 && $detail[1] > 100){
                    throw ValidationException::withMessages([
                    'logo_image' => [trans('The logo image file has invalid image dimensions.')],
                ]);
            }else{
                $input['logo_image'] = $this->image($photo,$user->id.'/invoice_setting');
            }
        }
        if($photo2 = $request->file('signature_image')){
            $detail2 = getimagesize($request['signature_image']);
            if($detail2[0] > 150 && $detail2[1] > 80){
                throw ValidationException::withMessages([
                    'signature_image' => [trans('The signature image file has invalid image dimensions.')],
                ]);
            }else{
                $input['signature_image'] = $this->image($photo2,$user->id.'/invoice_setting');
            }
        }

        if(!empty($invoice_setting)){
            $invoice_setting->update($input);
        }else{
            InvoiceSetting::create($input);
        }
        \Session::flash('message', 'Invoice setting has been updated successfully!');
        return redirect('invoice-setting');
    }
}

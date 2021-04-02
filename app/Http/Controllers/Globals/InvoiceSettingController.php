<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\InvoiceSetting;
use App\Models\Globals\States;
use Illuminate\Http\Request;
use WKPDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class InvoiceSettingController extends Controller
{
    public function __construct(){
        $this->middleware('multiauth:web');
//        $this->middleware('UserAccessRight');
        $this->common_controller = new CommonController();
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

//        if($photo = $request->file('company_logo')){
//            $detail = getimagesize($request['company_logo']);
//            if($detail[0] > 100 && $detail[1] > 100){
//                    throw ValidationException::withMessages([
//                    'company_logo' => [trans('The logo image file has invalid image dimensions.')],
//                ]);
//            }else{
//                $input['company_logo'] = $this->image($photo,$user->id.'/company');
//            }
//        }

//        if($photo2 = $request->file('signature_image')){
//            $input['signature_image'] = $this->image($photo2,$user->id.'/company');
//            $detail2 = getimagesize($request['signature_image']);
//            if($detail2[0] > 150 && $detail2[1] > 80){
//                throw ValidationException::withMessages([
//                    'signature_image' => [trans('The signature image file has invalid image dimensions.')],
//                ]);
//            }else{
//                $input['signature_image'] = $this->image($photo2,$user->id.'/company');
//            }
//        }

        //Company Logo
        $ext = 'png';
        $ext1 = 'png';
        if(!empty($request['original_file'])){
            $info = explode('.',$request['original_file']);
            $ext = $info[1];
            $input['company_logo'] = $this->common_controller->crop_image($request['selected_file'],$user->id.'/company', $ext);
        }

        //Signature Image
        if(!empty($request['original_signature_file'])){
            $info1 = explode('.',$request['original_signature_file']);
            $ext1 = $info1[1];
            $input['signature_image'] = $this->common_controller->crop_image($request['selected_signature_file'],$user->id.'/company', $ext1);
        }

        if(!empty($invoice_setting)){
            $invoice_setting->update($input);
        }else{
            CompanySettings::create($input);
        }
        \Session::flash('message', 'Company setting has been updated successfully!');
        return redirect('company-setting');
    }

    public function invoice_template(Request $request){
        $data['menu'] = 'Invoice Template';
        $data['user'] = Auth::user();
        $invoice_setting = CompanySettings::where('user_id',Auth::user()->id)->where('id',$this->Company())->first();

        $path = Auth::user()->id.'/company/invoice_template';
        $root = base_path() . '/public/upload/' . $path;
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }

        $old_pdf = 'upload/'.Auth::user()->id.'/company/invoice_template/sample_'.$invoice_setting['pdf_template'].'.pdf';
        $data['company'] = $invoice_setting;

        if(file_exists($old_pdf)){
            unlink($old_pdf);
        }

        if($invoice_setting['pdf_template'] == 1){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>28.1, 'ml'=>0, 'footer'=>'globals.invoice-setting.template.template_1_footer','color'=>$invoice_setting->color];
        }elseif ($invoice_setting['pdf_template'] == 2){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>10, 'ml'=>0, 'footer'=>'globals.invoice-setting.template.template_2_footer','color'=>$invoice_setting->color];
        }elseif ($invoice_setting['pdf_template'] == 3){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>12, 'ml'=>0, 'footer'=>'globals.invoice-setting.template.template_3_footer','color'=>$invoice_setting->color];
        }elseif ($invoice_setting['pdf_template'] == 4){
            $pdf_option = ['mt'=>10, 'mr'=>10, 'mb'=>10, 'ml'=>10, 'footer'=>'globals.invoice-setting.template.template_4_footer','color'=>$invoice_setting->color];
        }else{
            $pdf_option = ['mt'=>10, 'mr'=>10, 'mb'=>10, 'ml'=>10, 'footer'=>'globals.invoice-setting.template.template_5_footer','color'=>$invoice_setting->color];
        }

        $pdf = new WKPDF($this->common_controller->globalPdfOption($pdf_option));
        $pdf->addPage(view('globals.invoice-setting.template.template_'.$invoice_setting['pdf_template'],$data));

        if (!$pdf->saveAs($root.'/sample_'.$invoice_setting['pdf_template'].'.pdf')) {
            $error = $pdf->getError();
            return $error;
        }

        $data['invoice_setting'] = $invoice_setting;
//        return view('globals.invoice-setting.select_template',$data);
        return view('globals.invoice-setting.template_setting',$data);
    }

    public function invoice_update_template(Request $request){
        $invoice_setting = CompanySettings::where('user_id',Auth::user()->id)->where('id',$this->Company())->first();
        $input['pdf_template'] = $request['pdf_view'];
        $invoice_setting->update($input);
        \Session::flash('message', 'Invoice template has been changed successfully!');
        return redirect()->back();
    }

    public function set_invoice_view(Request $request){
        $user = Auth::user();
        $company = CompanySettings::where('id',$this->Company())->first();
        $path = $user->id.'/company/invoice_template';
        $root = base_path() . '/public/upload/' . $path;
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }

        $invoice_setting = CompanySettings::where('user_id',Auth::user()->id)->where('id',$this->Company())->first();

        $old_pdf = 'upload/'.$user->id.'/company/invoice_template/sample_'.$invoice_setting['pdf_template'].'.pdf';

        if(file_exists($old_pdf)){
            unlink($old_pdf);
        }

        if(isset($request['pdf_view'])){
            $input['pdf_template'] = $request['pdf_view'];
            $invoice_setting->update($input);
        }

        if(isset($request['color'])){
            $input['color'] = $request['color'];
            $invoice_setting->update($input);
        }

        if($invoice_setting['pdf_template'] == 1){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>28.1, 'ml'=>0, 'footer'=>'globals.invoice-setting.template.template_1_footer','color'=>$invoice_setting->color];
        }elseif ($invoice_setting['pdf_template'] == 2){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>10, 'ml'=>0, 'footer'=>'globals.invoice-setting.template.template_2_footer','color'=>$invoice_setting->color];
        }elseif ($invoice_setting['pdf_template'] == 3){
            $pdf_option = ['mt'=>0, 'mr'=>0, 'mb'=>12, 'ml'=>0, 'footer'=>'globals.invoice-setting.template.template_3_footer','color'=>$invoice_setting->color];
        }elseif ($invoice_setting['pdf_template'] == 4){
            $pdf_option = ['mt'=>10, 'mr'=>10, 'mb'=>10, 'ml'=>10, 'footer'=>'globals.invoice-setting.template.template_4_footer','color'=>$invoice_setting->color];
        }else{
            $pdf_option = ['mt'=>10, 'mr'=>10, 'mb'=>10, 'ml'=>10, 'footer'=>'globals.invoice-setting.template.template_5_footer','color'=>$invoice_setting->color];
        }
        $data['company'] = $invoice_setting;
        $data['user'] = $user->id;
        $pdf = new WKPDF($this->common_controller->globalPdfOption($pdf_option));
        $pdf->addPage(view('globals.invoice-setting.template.template_'.$invoice_setting['pdf_template'],$data));

        if (!$pdf->saveAs($root.'/sample_'.$invoice_setting['pdf_template'].'.pdf')) {
            $error = $pdf->getError();
            return $error;
        }else{
            return 1;
        }
    }
}
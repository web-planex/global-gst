@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
    </div>

    <x-emailverification/>

    <div class="content">
        @include('inc.message2')
        <div class="row">
            <div class="col-lg-12">
                {!! Form::model($invoice_setting,['url' => url('company-setting/addedit'),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'signupSuppliersForm']) !!}
                    @csrf
                    <div class="row mb-0">
                        <!--COMPANY DETAILS SETTING-->
                        <div class="col-lg-12">
                            <div class="card signature-image-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Company Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group mb-3 col-lg-6">
                                            <label for="company_logo" class="float-left">Company Logo</label>
                                            <div class="demo mb-3">
                                                <div class="crop-element" data-name="crop_open" data-crop-open="true" data-crop=">=100,>=100">
                                                    <img class="mt-1" id="crop_pro_image" src="@if(isset($invoice_setting) && !empty($invoice_setting) && !empty($invoice_setting['company_logo']) && file_exists($invoice_setting['company_logo'])) {{ url($invoice_setting['company_logo']) }} @endif"/>
                                                    <input type="file" id="logo_img" name="company_logo"/>
                                                </div>
                                            </div>
                                            <input type="hidden" name="selected_file" id="selected_file">
                                            <input type="hidden" name="original_file" id="original_file">

{{--                                            <label class="col-form-label">Company Logo</label>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <div class="input-group-prepend">--}}
{{--                                                    <span class="input-group-text"><i class="icon-picture"></i></span>--}}
{{--                                                </div>--}}
{{--                                                <div class="custom-file">--}}
{{--                                                    <input type="file" class="custom-file-input" name="company_logo" id="company_logo" onchange="AjaxUploadImage(this,1)">--}}
{{--                                                    <label class="custom-file-label" for="company_logo">Upload Logo Image</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            @if ($errors->has('company_logo'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('company_logo') }}</strong>
                                                </span>
                                            @endif
{{--                                            <p class="mt-2">Note: Image dimension should be less than 100 X 100 pixels.</p>--}}
{{--                                            <div class="form-group mb-0">--}}
{{--                                                @if(isset($invoice_setting) && !empty($invoice_setting) && !empty($invoice_setting['company_logo']) && file_exists($invoice_setting['company_logo']))--}}
{{--                                                    <img src="{{url($invoice_setting['company_logo'])}}" id="DisplayImage1" height="60px" width="60px" class="mt-2">--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
                                        </div>

                                        <div class="form-group mb-3 col-lg-6">
                                            <label for="company_logo" class="float-left">Signature Image</label>
                                            <div class="demo mb-3">
                                                <div class="crop-element" data-name="crop_open" data-crop-open="true" data-crop=">=150,>=80">
                                                    <img class="mt-1" id="crop_pro_sig_image" src="@if(isset($invoice_setting) && !empty($invoice_setting) && !empty($invoice_setting['signature_image']) && file_exists($invoice_setting['signature_image'])) {{ url($invoice_setting['signature_image']) }} @endif"/>
                                                    <input type="file" id="signature_img"/>
                                                </div>
                                            </div>
                                            <input type="hidden" name="selected_signature_file" id="selected_signature_file">
                                            <input type="hidden" name="original_signature_file" id="original_signature_file">

{{--                                            <label class="col-form-label">Signature Image</label>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <div class="input-group-prepend">--}}
{{--                                                    <span class="input-group-text"><i class="icon-picture"></i></span>--}}
{{--                                                </div>--}}
{{--                                                <div class="custom-file">--}}
{{--                                                    <input type="file" class="custom-file-input" name="signature_image" id="signature_image" onchange="AjaxUploadImage(this,2)">--}}
{{--                                                    <label class="custom-file-label" for="signature_image">Upload Signature Image</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            @if ($errors->has('signature_image'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('signature_image') }}</strong>
                                                </span>
                                            @endif
{{--                                            <p class="mt-2">Note: Image dimension should be less than 150 X 80 pixels and Image type png only.</p>--}}
{{--                                            <div class="form-group mb-0">--}}
{{--                                                @if(isset($invoice_setting) && !empty($invoice_setting) && !empty($invoice_setting['signature_image']) && file_exists($invoice_setting['signature_image']))--}}
{{--                                                    <img src="{{url($invoice_setting['signature_image'])}}" id="DisplayImage2" height="30px" width="120px" class="mt-2">--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="company_name">Company Name</label>
                                            {!! Form::text('company_name', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['company_name']:null, ['class' => 'form-control','id'=>'company_name']) !!}
                                            @if ($errors->has('company_name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('company_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="pan_no">Pan No</label>
                                            {!! Form::text('pan_no', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['pan_no']:null, ['class' => 'form-control','id'=>'pan_no']) !!}
                                            @if ($errors->has('pan_no'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('pan_no') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="gstin">GSTIN</label>
                                            {!! Form::text('gstin', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['gstin']:null, ['class' => 'form-control','id'=>'gstin']) !!}
                                            @if ($errors->has('gstin'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('gstin') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="company_email">Company Email</label>
                                            {!! Form::text('company_email', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['company_email']:null, ['class' => 'form-control','id'=>'company_email']) !!}
                                            @if ($errors->has('company_email'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('company_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="company_phone">Company Phone</label>
                                            {!! Form::text('company_phone', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['company_phone']:null, ['class' => 'form-control','id'=>'company_phone']) !!}
                                            @if ($errors->has('company_phone'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('company_phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="website">Website</label>
                                            {!! Form::text('website', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['website']:null, ['class' => 'form-control','id'=>'website']) !!}
                                            @if ($errors->has('website'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('website') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="street">Street</label>
                                            {!! Form::text('street', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['street']:null, ['class' => 'form-control','id'=>'street']) !!}
                                            @if ($errors->has('street'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('street') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="city">City</label>
                                            {!! Form::text('city', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['city']:null, ['class' => 'form-control','id'=>'city']) !!}
                                            @if ($errors->has('city'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="state">State</label>
                                            {!! Form::select('state', $states, isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['state']:null, ['class' => 'form-control amounts-are-select2', 'id'=>'state', 'style'=>'width:100%!important']) !!}
                                            @if ($errors->has('state'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group mb-3 col-md-6">
                                            <label for="pincode">Pincode</label>
                                            {!! Form::text('pincode', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['pincode']:null, ['class' => 'form-control','id'=>'pincode']) !!}
                                            @if ($errors->has('pincode'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('pincode') }}</strong>
                                                </span>
                                            @endif
                                        </div>

{{--                                        <div class="form-group mb-3 col-md-6">--}}
{{--                                            <label for="country">Country</label>--}}
{{--                                            {!! Form::text('country', isset($invoice_setting)&&!empty($invoice_setting)?$invoice_setting['country']:null, ['class' => 'form-control','id'=>'country']) !!}--}}
{{--                                            @if ($errors->has('country'))--}}
{{--                                                <span class="text-danger">--}}
{{--                                                    <strong>{{ $errors->first('country') }}</strong>--}}
{{--                                                </span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--GST STORE SETTING-->
                        <div class="col-lg-12">
                            <div class="card signature-image-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">GST Invoice Setting</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="iec_code" class="col-md-12 col-form-label">Import Export Code(IEC Code) </label>
                                                <div class="col-md-12">
                                                    {!! Form::text('iec_code', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('iec_code'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('iec_code') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="cin_number" class="col-md-12 col-form-label">CIN Number </label>
                                                <div class="col-md-12">
                                                    {!! Form::text('cin_number', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('cin_number'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('cin_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="fssai_lic_number" class="col-md-12 col-form-label">FSSAI LIC Number </label>
                                                <div class="col-md-12">
                                                    {!! Form::text('fssai_lic_number', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('fssai_lic_number'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('fssai_lic_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="invoice_prefix" class="col-md-12 col-form-label">Invoice Prefix </label>
                                                <div class="col-md-12">
                                                    {!! Form::text('invoice_prefix', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('invoice_prefix'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('invoice_prefix') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="invoice_number" class="col-md-12 col-form-label">Invoice Number </label>
                                                <div class="col-md-12">
                                                    {!! Form::number('invoice_number', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('invoice_number'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('invoice_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--CREDIT NOTE SETTING-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Credit Note Setting</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="credit_note_prefix" class="col-md-12 col-form-label">Credit Note Prefix </label>
                                                <div class="col-md-12">
                                                    {!! Form::text('credit_note_prefix', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('credit_note_prefix'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('credit_note_prefix') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="credit_note_number" class="col-md-12 col-form-label">Credit Note Number </label>
                                                <div class="col-md-12">
                                                    {!! Form::number('credit_note_number', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('credit_note_number'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('credit_note_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--estimate SETTING-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Estimate Setting</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="credit_note_prefix" class="col-md-12 col-form-label">Estimate Prefix </label>
                                                <div class="col-md-12">
                                                    {!! Form::text('estimate_prefix', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('estimate_prefix'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('estimate_prefix') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="estimate_number" class="col-md-12 col-form-label">Estimate Number </label>
                                                <div class="col-md-12">
                                                    {!! Form::number('estimate_number', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('estimate_number'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('estimate_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--PRODUCT PRICE SETTING-->
                        <!-- comment start -->
                        {{--<div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Product Price Setting</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="product-price-setting-section">GST is included in product price
                                                    {!! Form::checkbox('product_price_gst', isset($invoice_setting) && $invoice_setting['product_price_gst']==1?1:null, isset($invoice_setting)&&!empty($invoice_setting['product_price_gst'])?true:false, ['class' => 'js-switch', 'id'=>'product_price_gst', 'data-color'=>'#01c0c8', 'data-switchery'=>'true','style'=>'display:none;']) !!}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="product-price-setting-section">Show GST on shipping
                                                    {!! Form::checkbox('shipping_gst', isset($invoice_setting) && $invoice_setting['shipping_gst']==1?1:null, isset($invoice_setting)&&!empty($invoice_setting['shipping_gst'])?true:false, ['class' => 'js-switch', 'id'=>'shipping_gst', 'data-color'=>'#01c0c8', 'data-switchery'=>'true','style'=>'display:none;']) !!}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="product-price-setting-section">GST is included in shipping price
                                                    {!! Form::checkbox('shipping_price_gst', isset($invoice_setting) && $invoice_setting['shipping_price_gst']==1?1:null, isset($invoice_setting)&&!empty($invoice_setting['shipping_price_gst'])?true:false, ['class' => 'js-switch', 'id'=>'shipping_price_gst', 'data-color'=>'#01c0c8', 'data-switchery'=>'true','style'=>'display:none;']) !!}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="product-price-setting-section">Charge IGST On Export Orders
                                                    {!! Form::checkbox('igst_on_export_order', isset($invoice_setting) && $invoice_setting['igst_on_export_order']==1?1:null, isset($invoice_setting)&&!empty($invoice_setting['igst_on_export_order'])?true:false, ['class' => 'js-switch', 'id'=>'igst_on_export_order', 'data-color'=>'#01c0c8', 'data-switchery'=>'true','style'=>'display:none;']) !!}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                        <!-- comment end -->

                        <!--TERMS & CONDITION-->
                        <div class="col-lg-12">
                            <div class="card email-notifications-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Terms and Condition</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            {!! Form::textarea('terms_and_condition', null, ['class' => 'form-control','rows'=>10]) !!}
                                            @if ($errors->has('terms_and_condition'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('terms_and_condition') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--EMAIL NOTIFICATION-->
                        {{--<div class="col-lg-6">
                            <div class="card email-notifications-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Email Notification</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        @foreach(\App\Models\Globals\InvoiceSetting::$email_notification as $key2 =>$value2)
                                            <div class="col-md-12">
                                                <div class="custom-control custom-radio mb-2">
                                                    {!! Form::radio('email_notification', $key2, null, ['class' => 'custom-control-input', 'id'=>'email_'.$key2]) !!}
                                                    <label for="email_{{$key2}}" class="custom-control-label"> {{$value2}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>--}}

                        <!--AUTOMATIC EMAIL NOTIFICATION SETTING-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Automatic Email Notifications</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label class="product-price-setting-section">Send a copy of all automatic emails to: (Enter comma separated for multiple email Ids)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    {!! Form::text('email_notification_for_site_admin', null, ['class' => 'form-control']) !!}
                                                    @if ($errors->has('email_notification_for_site_admin'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('email_notification_for_site_admin') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit" name="submit" class="btn btn-default btn-lg btn-primary mb-3">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@section('page_confirmation_script')
<script src="{{asset('js/page_confirmation_script.js')}}"></script>
@endsection
    <script>
        function AjaxUploadImage(obj,id){
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
            function imageIsLoaded(e) {
                $('#DisplayImage'+id).css("display", "block");
                $('#DisplayImage'+id).attr('src', e.target.result);
                if(id==1){
                    $('#DisplayImage1').attr('width', '60');
                }
                if(id==2){
                    $('#DisplayImage2').attr('width', '150');
                }
            }
        }

        //For Company Logo
        $('#logo_img').on('change',function(){
            $('#original_file').val($(this).val());
        });

        var divimg1 = document.getElementById("crop_pro_image"),
            prevSrc1;
        setInterval(function() {
            if (divimg1.src != prevSrc1) {
                prevSrc1 = divimg1.src;
                onSrcChange1();
            }
        }, 1000); // 1000ms = 1s

        function onSrcChange1() {
            var img = document.getElementById("crop_pro_image").src;
            $('#selected_file').val(img) ;
        }

        //For Signature Image
        $('#signature_img').on('change',function(){
            $('#original_signature_file').val($(this).val());
        });

        var divimg = document.getElementById("crop_pro_sig_image"),
            prevSrc;
        setInterval(function() {
            if (divimg.src != prevSrc) {
                prevSrc = divimg.src;
                onSrcChange();
            }
        }, 1000); // 1000ms = 1s

        function onSrcChange() {
            var img1 = document.getElementById("crop_pro_sig_image").src;
            $('#selected_signature_file').val(img1);
        }

    </script>
@endsection

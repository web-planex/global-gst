@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
    </div>
    <div class="content">
        @include('inc.message2')
        <div class="row">
            <div class="col-lg-12">
                {!! Form::model($invoice_setting,['url' => url('company-setting/addedit'),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'signupSuppliersForm']) !!}
                    @csrf
                    <div class="row mb-0">
                        <!--LOGO IMAGE-->
                        <div class="col-lg-6">
                            <div class="card signature-image-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Company Logo</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        <label class="col-form-label">Company Logo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-picture"></i></span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="company_logo" id="company_logo" onchange="AjaxUploadImage(this,1)">
                                                <label class="custom-file-label" for="company_logo">Upload Logo Image</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('company_logo'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('company_logo') }}</strong>
                                            </span>
                                        @endif
                                        <p class="mt-2">Note: Image dimension should be less than 100X100 pixels.</p>
                                    </div>

                                    <div class="form-group mb-0">
                                        @if(isset($invoice_setting) && !empty($invoice_setting) && !empty($invoice_setting['company_logo']) && file_exists($invoice_setting['company_logo']))
                                            <img src="{{url($invoice_setting['company_logo'])}}" id="DisplayImage1" height="60px" width="60px">
                                        @else
                                            <img src="" id="DisplayImage1" height="60px" width="60px" style="display: none;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--SIGNATURE IMAGE-->
                        <div class="col-lg-6">
                            <div class="card signature-image-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Signature Image</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        <label class="col-form-label">Signature Image</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-picture"></i></span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="signature_image" id="signature_image" onchange="AjaxUploadImage(this,2)">
                                                <label class="custom-file-label" for="signature_image">Upload Signature Image</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('signature_image'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('signature_image') }}</strong>
                                            </span>
                                        @endif
                                        <p class="mt-2">Note: Image dimension should be less than 150X80 pixels and Image type png only.</p>
                                    </div>

                                    <div class="form-group mb-0">
                                        @if(isset($invoice_setting) && !empty($invoice_setting) && !empty($invoice_setting['signature_image']) && file_exists($invoice_setting['signature_image']))
                                            <img src="{{url($invoice_setting['signature_image'])}}" id="DisplayImage2" height="30px" width="120px">
                                        @else
                                            <img src="" id="DisplayImage2" height="30px" width="120px" style="display: none;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--GST STORE SETTING-->
                        <div class="col-lg-12">
                            <div class="card signature-image-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">GST Store Setting</h4>
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

                        <!--PRODUCT PRICE SETTING-->
                        <div class="col-lg-12">
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
                        </div>

                        <!--TERMS & CONDITION-->
                        <div class="col-lg-6">
                            <div class="card email-notifications-bg">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Terms and Condition</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            {!! Form::textarea('terms_and_condition', null, ['class' => 'form-control','rows'=>5]) !!}
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
                        <div class="col-lg-6">
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
                        </div>

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
                                                <div class="col-md-6">
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
                    <button type="submit" name="submit" class="btn btn-default btn-lg btn-primary mb-3">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

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
    </script>
@endsection

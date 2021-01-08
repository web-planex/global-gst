@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">@if(isset($companies)) Edit @else Add @endif Companies</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(isset($companies))
                        {!! Form::model($companies,['url' => url('companies/'.$companies->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'CompaniesForm']) !!}
                    @else
                        {!! Form::open(['url' => url('companies'), 'class' => 'form-horizontal','files'=>true,'id'=>'CompaniesForm']) !!}
                    @endif
                    <div class="row" id="Suppliers">
                        <div class="form-group mb-3 col-md-12">
                            <label for="company_logo">Company Logo</label><br>
                            @if(isset($companies)&&!empty($companies) && !empty($companies['company_logo']))
                                <div id="imagePreview" style="background-image: url({{url($companies['company_logo'])}});" class="form-control mt-2"></div>
                            @else
                                <div id="imagePreview" src="" class="form-control mt-2"></div>
                            @endif
                            <input id="uploadFile" type="file" name="company_logo" class="img" />
                            <br><span class="text-danger hide" id="img_msg"></span>
                            @if ($errors->has('company_logo'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_logo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="company_name">Company Name <span class="text-danger">*</span></label>
                            {!! Form::text('company_name', null, ['class' => 'form-control','id'=>'company_name']) !!}
                            @if ($errors->has('company_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="pan_no">Pan No <span class="text-danger">*</span></label>
                            {!! Form::text('pan_no', null, ['class' => 'form-control','id'=>'pan_no']) !!}
                            @if ($errors->has('pan_no'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pan_no') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="gstin">GSTIN <span class="text-danger">*</span></label>
                            {!! Form::text('gstin', null, ['class' => 'form-control','id'=>'gstin']) !!}
                            @if ($errors->has('gstin'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('gstin') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="company_email">Company Email <span class="text-danger">*</span></label>
                            {!! Form::text('company_email', null, ['class' => 'form-control','id'=>'company_email']) !!}
                            @if ($errors->has('company_email'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="company_phone">Company Phone <span class="text-danger">*</span></label>
                            {!! Form::text('company_phone', null, ['class' => 'form-control','id'=>'company_phone']) !!}
                            @if ($errors->has('company_phone'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="website">Website</label>
                            {!! Form::text('website', isset($companies)&&!empty($companies)?$companies['website']:null, ['class' => 'form-control','id'=>'website']) !!}
                            @if ($errors->has('website'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="street">Street <span class="text-danger">*</span></label>
                            {!! Form::text('street', null, ['class' => 'form-control','id'=>'street']) !!}
                            @if ($errors->has('street'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('street') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="city">City <span class="text-danger">*</span></label>
                            {!! Form::text('city', null, ['class' => 'form-control','id'=>'city']) !!}
                            @if ($errors->has('city'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="state">State <span class="text-danger">*</span></label>
                            {!! Form::select('state', $states, null, ['class' => 'form-control amounts-are-select2','id'=>'state']) !!}
                            @if ($errors->has('state'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="pincode">Pincode <span class="text-danger">*</span></label>
                            {!! Form::text('pincode', null, ['class' => 'form-control','id'=>'pincode']) !!}
                            @if ($errors->has('pincode'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pincode') }}</strong>
                                </span>
                            @endif
                        </div>

{{--                        <div class="form-group mb-3 col-md-6">--}}
{{--                            <label for="country">Country <span class="text-danger">*</span></label>--}}
{{--                            {!! Form::text('country', null, ['class' => 'form-control','id'=>'country']) !!}--}}
{{--                            @if ($errors->has('country'))--}}
{{--                                <span class="text-danger">--}}
{{--                                    <strong>{{ $errors->first('country') }}</strong>--}}
{{--                                </span>--}}
{{--                            @endif--}}
{{--                        </div>--}}

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function(){
            $("#uploadFile").on("change", function(){
                var files = !!this.files ? this.files : [];
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((files[0].type == match[0]) || (files[0].type == match[1]) || (files[0].type == match[2]))){
                    $('#img_msg').html('<strong>Please Select A valid Image File</strong>');
                    $('#img_msg').addClass('show');
                    $('#img_msg').removeClass('hide');
                }else{
                    $('#img_msg').addClass('hide');
                    $('#img_msg').removeClass('show');
                }
                if (!files.length || !window.FileReader) return;
                if (/^image/.test( files[0].type)){
                    var reader = new FileReader();
                    reader.readAsDataURL(files[0]);
                    reader.onloadend = function(){
                        $("#imagePreview").css("background-image", "url("+this.result+")");
                    }
                }
            });
        });

        $('#imagePreview').click(function(){
            $('#uploadFile').click();
        });

        $().ready(function() {
            $("#CompaniesForm").validate({
                rules: {
                    company_name: "required",
                    pan_no: "required",
                    gstin: "required",
                    company_email: "required",
                    company_phone: "required",
                    street: "required",
                    city: "required",
                    state: "required",
                    pincode: "required",
                    // country: "required",
                },
                messages: {
                    company_name: "The company name field is required",
                    pan_no: "The pan number field is required",
                    gstin: "The gstin field is required",
                    company_email: "Please enter a valid email address",
                    company_phone: "The company phone field is required",
                    street: "The street field is required",
                    city: "The city field is required",
                    state: "The state field is required",
                    pincode: "The pincode field is required",
                    // country: "The country field is required",
                }
            });
        });
    </script>
@endsection